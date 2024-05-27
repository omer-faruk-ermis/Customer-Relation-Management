<?php

namespace App\Helpers;

use App\Enums\Code;
use App\Exceptions\Auth\SessionTimeOutException;
use App\Exceptions\Code\SecurityCodeIncorrectException;
use App\Exceptions\Code\SecurityCodeMaxAttemptException;
use App\Exceptions\Code\SecurityCodeUseTimeException;
use App\Exceptions\Sms\SmsIdentityNotVerifiedException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class SmsVerificationValidate
{
    /**
     * @param Request $request
     * @return void
     * @throws Exception
     */
    public static function handle(Request $request): void
    {
        $token = $request->input('netgsmsessionid');
        CacheOperation::imageClear($token);

        if (!Cache::has("verification_code_info_$token")) {
            throw new SessionTimeOutException();
        }

        $verifierData = Cache::get("verification_code_info_$token");

        if (Arr::get($verifierData, 'create_date')->diffInSeconds(Carbon::now()) > Code::DEFAULT_CODE_REMAINING_TIME) {
            Cache::forget("verification_code_info_$token");
            throw new SecurityCodeUseTimeException();
        }

        if (Arr::get($verifierData, 'code_max_use') < Arr::get($verifierData, 'code_used_counter')) {
            Cache::forget("verification_code_info_$token");
            throw new SecurityCodeMaxAttemptException();
        }

        if (Arr::get($verifierData, 'code') !== $request->input('code')) {
            $remainingAttempts = $verifierData['code_max_use'] - $verifierData ['code_used_counter'];
            $verifierData['code_used_counter']++;
            Cache::put("verification_code_info_$token", $verifierData);
            throw new SecurityCodeIncorrectException("Girdiğiniz kod hatalı. Kalan deneme hakkı: $remainingAttempts");
        }

        $sms_kimlik = Cache::get("sms_kimlik_$token") ?? Cache::get("sms_kimlik_password_$token");
        if (empty($sms_kimlik)) {
            throw new SmsIdentityNotVerifiedException();
        }

        Cache::put("login_$token", $sms_kimlik);
    }
}
