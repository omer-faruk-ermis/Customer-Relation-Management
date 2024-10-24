<?php

namespace App\Helpers;

use App\Builder\SmsKimlikBuilder;
use App\Enums\DefaultConstant;
use App\Exceptions\Auth\LoginAlreadyException;
use App\Exceptions\Auth\NotLoginException;
use App\Models\SmsKimlik\SmsKimlik;
use App\Utils\ArrayUtil;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class CacheOperation
{
    /**
     * @param $token
     *
     * @return void
     * @throws Exception
     */
    public static function imageClear($token): void
    {
        if (Cache::has("sms_kimlik_image_$token")) {
            $image_path = Cache::get("sms_kimlik_image_$token");
            Cache::forget("sms_kimlik_image_$image_path");

            if (Cache::has("security_code_$image_path")) {
                Cache::forget("security_code_$image_path");
            }
            Storage::delete("public/$image_path");
        }
    }

    /**
     * @param $token
     *
     * @return void
     * @throws Exception
     */
    public static function verifierCodeClear($token): void
    {
        if (Cache::has("verification_code_info_$token")) {
            Cache::forget("verification_code_info_$token");
        }
    }

    /**
     * @param $request
     *
     * @return SmsKimlik
     * @throws Exception
     */
    public static function setSession($request): SmsKimlik
    {
        $netgsmsessionid = $request->bearerToken();
        TokenValidate::handle($netgsmsessionid);
        $sms_kimlik = SmsKimlikBuilder::handle(Cache::get("sms_kimlik_$netgsmsessionid"), $netgsmsessionid);

        Cache::put("sms_kimlik_$netgsmsessionid", $sms_kimlik);
        Redis::connection('prod')->set("yonetimsession:$netgsmsessionid", json_encode(Arr::except($sms_kimlik, ['unit', 'sip']), JSON_UNESCAPED_UNICODE));
        Redis::connection('prod')->command('EXPIRE', ["yonetimsession:$netgsmsessionid", DefaultConstant::CACHE_ONE_DAY]);

        return $sms_kimlik;
    }

    /**
     * @param string  $token
     *
     * @return void
     * @throws NotLoginException
     */
    public static function refreshEmployeeSession(string $token): void
    {
        $redisEmployee = Redis::connection('prod')->get("yonetimsession:$token");
        if (empty($redisEmployee)) {
            throw new NotLoginException();
        }

        Cache::put("sms_kimlik_$token", ArrayUtil::castArray($redisEmployee));
    }
}
