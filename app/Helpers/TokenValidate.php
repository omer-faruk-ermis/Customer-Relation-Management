<?php

namespace App\Helpers;

use App\Enums\RegexPattern;
use App\Enums\Url\ExcludeRoute;
use App\Exceptions\Token\InvalidTokenException;
use App\Exceptions\Token\InvalidTokenFormatException;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class TokenValidate
{
    /**
     * @param $token
     *
     * @return void
     * @throws Exception
     */
    public static function handle($token): void
    {
        if (!preg_match(RegexPattern::TOKEN, $token)) {
            throw new InvalidTokenFormatException();
        }

        $sms_kimlik = Cache::get("sms_kimlik_$token");
        $sms_kimlik_password = Cache::get("sms_kimlik_password_$token");

        if (empty($sms_kimlik)) {
            throw new InvalidTokenException();
        }

        if (Arr::get(Request()->server->all(), 'PATH_INFO') == ExcludeRoute::FORGOT_PASSWORD
            && empty($sms_kimlik_password)) {
            throw new InvalidTokenException();
        }

        if ($sms_kimlik['netgsmsessionid'] !== $token) {
            throw new InvalidTokenException();
        }

        if (!empty($sms_kimlik_password) && $sms_kimlik_password['netgsmsessionid'] !== $token) {
            throw new InvalidTokenException();
        }
    }
}
