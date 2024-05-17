<?php

namespace App\Helpers;

use App\Enums\Code;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class CodeGenerator
{
    /**
     * Generates a random security code [0-9][A-F].
     *
     * @param int $length
     * @return string
     */
    public static function generateCode(int $length = 6): string
    {
        return strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, $length));
    }

    /**
     * Generates a random code [0-9][A-Z][a-z].
     *
     * @param int $length
     * @return string
     */
    public static function generateRandomAlphanumericCode(int $length = 15): string
    {
        return substr(str_shuffle(Code::ALPHANUMERIC_CODE), 0, $length);
    }

    /**
     * Generates an image containing the security code.
     *
     * @param int $width
     * @param int $height
     * @return string
     */
    public static function generateSecurityCodeImage(int $width = 120, int $height = 40): string
    {
        $security_code = self::generateCode();

        $image = imagecreatetruecolor($width, $height);

        $bg_color = imagecolorallocate($image, 255, 255, 255);
        $text_color = imagecolorallocate($image, 0, 0, 0);

        imagefill($image, 0, 0, $bg_color);

        imagestring($image, 50, 30, 10, $security_code, $text_color);

        $image_path = 'images/security_code_' . time() . '.png';
        imagepng($image, storage_path('app/public/' . $image_path));

        Cache::put('security_code_' . $image_path, $security_code, now()->addHour());

        return $image_path;
    }

    /**
     * @param string $token
     * @return array
     */
    public static function getVerifierData(string $token): array
    {
        $verifierData = [];
        $verifierData = Arr::add($verifierData, 'code', self::generateCode());
        $verifierData = Arr::add($verifierData, 'ref_code', self::generateCode(Code::REF_CODE));
        $verifierData = Arr::add($verifierData, 'code_max_use', Code::CODE_MAX_USE);
        $verifierData = Arr::add($verifierData, 'code_used_counter', Code::CODE_USED_DEFAULT_COUNTER);
        $verifierData = Arr::add($verifierData, 'create_date', Carbon::now());

        Cache::put("verification_code_info_$token", $verifierData);

        return $verifierData;
    }
}
