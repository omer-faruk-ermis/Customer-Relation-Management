<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CacheClear
{
    /**
     * @param $token
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
     * @return void
     * @throws Exception
     */
    public static function verifierCodeClear($token): void
    {
        if (Cache::has("verification_code_info_$token")) {
            Cache::forget("verification_code_info_$token");
        }
    }
}
