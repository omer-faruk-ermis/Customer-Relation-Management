<?php

namespace App\Services\Auth;

use App\Builder\SmsKimlikBuilder;
use App\Enums\Status;
use App\Exceptions\Auth\AuthInformationException;
use App\Exceptions\Auth\LoginAlreadyException;
use App\Exceptions\Auth\NotLoginException;
use App\Exceptions\Auth\OldPasswordException;
use App\Helpers\CacheOperation;
use App\Helpers\CodeValidate;
use App\Helpers\PasswordValidate;
use App\Helpers\TokenValidate;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LoginVerificationRequest;
use App\Http\Requests\Auth\NewPasswordRequest;
use App\Http\Requests\Sms\SmsVerificationRequest;
use App\Models\SmsKimlik\SmsKimlik;
use App\Services\Sms\SmsService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

/**
 * Class AuthService
 *
 * @package App\Service\Auth
 */
class AuthService
{
    /**
     * @param LoginRequest  $request
     *
     * @return object
     * @throws Exception
     */
    public function login(LoginRequest $request): object
    {
        CodeValidate::handle($request);

        $sms_kimlik = SmsKimlik::with(['sip', 'unit'])
                               ->whereNotNull('sms_kimlik_email')
                               ->whereNotNull('sifre')
                               ->whereNotNull('ceptel')
                               ->where('sms_kimlik_email', '=', $request->input('email'))
                               ->where('loginpage', '=', Status::ACTIVE)
                               ->active()
                               ->where('sifre', '=', $request->input('password'))
                               ->latest('id')
                               ->first();

        if (empty($sms_kimlik)) {
            throw new AuthInformationException();
        }

        $token = Session::getId();
        Cache::put("sms_kimlik_$token", Arr::add($sms_kimlik, 'netgsmsessionid', $token), now()->addHours(24));
        Cache::put("sms_kimlik_image_$token", $request->input('security_code_path'));

        return (object)['token' => $token];
    }

    /**
     * @param LoginVerificationRequest  $request
     *
     * @return SmsKimlik
     * @throws Exception
     */
    public function loginVerification(LoginVerificationRequest $request): SmsKimlik
    {
        $netgsmsessionid = $request->bearerToken();
        if (empty(Cache::get("login_$netgsmsessionid"))) {
            if (!empty(Redis::connection('prod')->get("yonetimsession:$netgsmsessionid"))) {
                CacheOperation::refreshEmployeeSession($netgsmsessionid);
                $smsKimlik = SmsKimlikBuilder::handle(new SmsKimlik(Cache::get("sms_kimlik_$netgsmsessionid")), $netgsmsessionid);
                Cache::put("login_$netgsmsessionid", $smsKimlik);
                return $smsKimlik;
            } else {
                throw new NotLoginException();
            }
        }

        if (empty(Redis::connection('prod')->get("yonetimsession:$netgsmsessionid"))) {
            return CacheOperation::setSession($request)->load('sip', 'unit');
        }

        throw new LoginAlreadyException();
    }

    /**
     * @param ForgotPasswordRequest  $request
     *
     * @return object
     * @throws Exception
     */
    public function forgotPassword(ForgotPasswordRequest $request): object
    {
        CodeValidate::handle($request);

        $sms_kimlik = SmsKimlik::whereNotNull('sms_kimlik_email')
                               ->whereNotNull('ceptel')
                               ->whereNotNull('sifre')
                               ->where('sms_kimlik_email', '=', $request->input('email'))
                               ->active()
                               ->first();

        if (empty($sms_kimlik)) {
            throw new AuthInformationException();
        }

        $token = Session::getId();
        Cache::put("sms_kimlik_password_$token", Arr::add($sms_kimlik, 'netgsmsessionid', $token), now()->addHour());
        Cache::put("sms_kimlik_image_$token", $request->input('security_code_path'));

        return (object)['token' => $token];
    }

    /**
     * @param NewPasswordRequest  $request
     *
     * @return void
     * @throws Exception
     */
    public function newPassword(NewPasswordRequest $request): void
    {
        PasswordValidate::handle($request);

        $smsRequest = new SmsVerificationRequest([
                                                     'netgsmsessionid' => $request->bearerToken(),
                                                     'code'            => $request->input('code'),
                                                 ]);

        $smsRequest->headers->set('Authorization', 'Bearer ' . $request->bearerToken());

        SmsService::smsVerification($smsRequest);

        $token = $request->bearerToken();
        $sms_kimlik = Cache::get("sms_kimlik_password_$token");
        if (empty($sms_kimlik)) {
            throw new AuthInformationException();
        }
        Arr::except($sms_kimlik, 'netgsmsessionid');

        $sms_kimlik->update(['sifre' => $request->input('new_password')]);
    }

    /**
     * @param ChangePasswordRequest  $request
     *
     * @return void
     * @throws Exception
     */
    public function changePassword(ChangePasswordRequest $request): void
    {
        PasswordValidate::handle($request);

        if (empty(Auth::user()) || (Arr::get(Auth::user(), 'sifre') !== $request->input('old_password'))) {
            throw new OldPasswordException();
        }

        $user = SmsKimlik::find(Auth::id());
        $user->update(['sifre' => $request->input('new_password')]);

        $token = $request->bearerToken();
        $sms_kimlik = Cache::get("sms_kimlik_$token");
        $sms_kimlik->sifre = $user->sifre;

        Cache::put("sms_kimlik_$token", $sms_kimlik);
        CacheOperation::refreshEmployeeSession($token);
    }

    /**
     * @param Request  $request
     *
     * @return void
     * @throws Exception
     */
    public function logout(Request $request): void
    {
        $token = $request->bearerToken();

        TokenValidate::handle($token);

        Session::flush();
        Cache::forget("sms_kimlik_$token");
        CacheOperation::verifierCodeClear($token);
        Redis::connection('prod')->command('DEL', ["yonetimsession:$token"]);
        Auth::logout();
    }
}
