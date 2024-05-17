<?php

namespace App\Utils;

use App\Enums\Encryption;

/**
 * Class Security
 *
 * @package App\Utils
 */
final class Security
{
    /**
     * @param string|null  $entry
     *
     * @return string
     */
    public static function encrypt(string $entry = null): string
    {
        $randomIv = openssl_random_pseudo_bytes(Encryption::CIPHERING_LENGTH);

        return str_replace(
            ['+', '/', '='],
            ['-', '_', ''],
            base64_encode($randomIv . openssl_encrypt(
                              $entry,
                              Encryption::CIPHERING,
                              Encryption::KEY,
                              OPENSSL_RAW_DATA,
                              $randomIv
                          )
            )
        );
    }

    /**
     * @param string|null  $code
     *
     * @return false|string
     */
    public static function decrypt(string $code = null): false|string
    {
        if (!empty($code)) {
            return openssl_decrypt(
                substr(base64_decode(str_replace(['-', '_'], ['+', '/'], $code)), Encryption::CIPHERING_LENGTH),
                Encryption::CIPHERING,
                Encryption::KEY,
                OPENSSL_RAW_DATA,
                substr(base64_decode(str_replace(['-', '_'], ['+', '/'], $code)), 0, Encryption::CIPHERING_LENGTH)
            );
        }
        return false;
    }

}
