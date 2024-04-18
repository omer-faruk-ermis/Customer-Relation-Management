<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class XmlGenerator
{
    /**
     * @param string $token
     * @return array|false|string
     */
    public static function otpSms(string $token): array|false|string
    {
        $xmlData = file_get_contents(resource_path('xml/otpMessage.xml'));

        $verifierData = CodeGenerator::getVerifierData($token);

        return str_replace(
            [
                '{USER_CODE}',
                '{PASSWORD}',
                '{MSG_HEADER}',
                '{APP_KEY}',
                '{CODE}',
                '{REF_CODE}',
                '{GSM}'
            ],
            [
                config('git.user_code'),
                config('git.password'),
                config('git.header'),
                config('git.app_key'),
                $verifierData['code'],
                $verifierData['ref_code'],
                Cache::get("sms_kimlik_$token")->ceptel ?? Cache::get("sms_kimlik_password_$token")->ceptel
            ],
            $xmlData
        );
    }

    /**
     * @param string $token
     * @return array|false|string
     */
    public static function sms(string $token): array|false|string
    {
        $xmlData = file_get_contents(resource_path('xml/smsMessage.xml'));

        $verifierData = CodeGenerator::getVerifierData($token);

        return str_replace(
            [
                '{COMPANY}',
                '{USER_CODE}',
                '{PASSWORD}',
                '{MSG_HEADER}',
                '{APP_KEY}',
                '{CODE}',
                '{REF_CODE}',
                '{GSM}'
            ],
            [
                'Netgsm',
                config('git.user_code'),
                config('git.password'),
                config('git.header'),
                config('git.app_key'),
                $verifierData['code'],
                $verifierData['ref_code'],
                Cache::get("sms_kimlik_$token")->ceptel ?? Cache::get("sms_kimlik_password_$token")->ceptel
            ],
            $xmlData
        );
    }
}
