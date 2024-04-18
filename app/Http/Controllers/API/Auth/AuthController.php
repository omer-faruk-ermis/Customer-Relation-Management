<?php

namespace App\Http\Controllers\API\Auth;

use App\Builder\SmsKimlikBuilder;
use App\Enums\DefaultConstant;
use App\Enums\Status;
use App\Exceptions\Auth\AuthInformationException;
use App\Exceptions\Auth\OldPasswordException;
use App\Helpers\CacheClear;
use App\Helpers\CodeValidate;
use App\Helpers\PasswordValidate;
use App\Helpers\TokenValidate;
use App\Http\Controllers\API\Sms\SmsController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LoginVerificationRequest;
use App\Http\Requests\Auth\NewPasswordRequest;
use App\Http\Requests\Sms\SmsVerificationRequest;
use App\Models\SmsKimlik\SmsKimlik;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Throwable;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function login(LoginRequest $request): JsonResponse
    {
        CodeValidate::handle($request);

        $sms_kimlik =
            SmsKimlik::whereNotNull('sms_kimlik_email')
                ->whereNotNull('sifre')
                ->whereNotNull('ceptel')
                ->where('sms_kimlik_email', '=', $request->input('sms_kimlik_email'))
                ->where('loginpage', '=', Status::ACTIVE)
                ->where('durum', '=', Status::ACTIVE)
                ->where('sifre', '=', $request->input('sifre'))
                ->first();

        if (empty($sms_kimlik)) {
            throw new AuthInformationException();
        }

        $token = Session::getId();
        Cache::put("sms_kimlik_$token", Arr::add($sms_kimlik, 'netgsmsessionid', $token), now()->addHours(24));
        Cache::put("sms_kimlik_image_$token", $request->input('security_code_path'));

        return response()->json(['success' => $token]);
    }

    /**
     * @param LoginVerificationRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function loginVerification(LoginVerificationRequest $request): JsonResponse
    {
        $netgsmsessionid = $request->input('netgsmsessionid');
        $sms_kimlik = Cache::get("sms_kimlik_$netgsmsessionid");
        $sms_kimlik = SmsKimlikBuilder::handle(Cache::get("sms_kimlik_$netgsmsessionid"));
        $birim = $sms_kimlik['birim'];

        Redis::connection('prod')->set("yonetimsession:$netgsmsessionid", json_encode(Arr::except($sms_kimlik, 'birim')));
        Redis::connection('prod')->command('EXPIRE', ["yonetimsession:$netgsmsessionid", DefaultConstant::CACHE_ONE_DAY]);

        return response()->json(['success' => Arr::add($sms_kimlik, 'birim', $birim)]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->input('netgsmsessionid');

        TokenValidate::handle($token);

        Session::flush();
        Cache::forget("sms_kimlik_$token");
        CacheClear::verifierCodeClear($token);
        Redis::connection('prod')->command('DEL', ["yonetimsession:$token"]);
        Auth::logout();

        return response()->json(['success' => true]);
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        CodeValidate::handle($request);

        $sms_kimlik =
            SmsKimlik::whereNotNull('sms_kimlik_email')
                ->whereNotNull('ceptel')
                ->whereNotNull('sifre')
                ->where('sms_kimlik_email', '=', $request->input('sms_kimlik_email'))
                ->where('durum', '=', Status::ACTIVE)
                ->first();

        if (empty($sms_kimlik)) {
            throw new AuthInformationException();
        }

        $token = Session::getId();
        Cache::put("sms_kimlik_password_$token", Arr::add($sms_kimlik, 'netgsmsessionid', $token), now()->addHour());
        Cache::put("sms_kimlik_image_$token", $request->input('security_code_path'));

        return response()->json(['success' => $token]);
    }

    /**
     * @param NewPasswordRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function newPassword(NewPasswordRequest $request): JsonResponse
    {
        PasswordValidate::handle($request);

        $smsRequest = new SmsVerificationRequest([
            'netgsmsessionid' => $request->input('netgsmsessionid'),
            'code'            => $request->input('code'),
        ]);
        SmsController::smsVerification($smsRequest);

        $token = $request->input('netgsmsessionid');
        $sms_kimlik = Cache::get("sms_kimlik_password_$token");
        if (empty($sms_kimlik)) {
            throw new AuthInformationException();
        }
        Arr::except($sms_kimlik, 'netgsmsessionid');

        return response()->json(['success' => $sms_kimlik->update(['sifre' => $request->input('new_password')])]);
    }

    /**
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        PasswordValidate::handle($request);

        $token = $request->input('netgsmsessionid');
        $sms_kimlik = Cache::get("sms_kimlik_$token");
        if ($sms_kimlik['sifre'] !== $request->input('old_password')) {
            throw new OldPasswordException();
        }
        Arr::except($sms_kimlik, 'netgsmsessionid');

        return response()->json(['success' => $sms_kimlik->update(['sifre' => $request->input('new_password')])]);
    }
}
