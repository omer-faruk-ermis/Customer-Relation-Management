<?php

namespace App\Enums\Url;

use App\Enums\AbstractEnum;

class ApiNetgsmUrl extends AbstractEnum
{
    private static string $base_url = 'https://api.netgsm.com.tr/';
    public const SEND_GET_SMS = 'sms/send/get';
    public const SEND_XML_SMS = 'sms/send/xml';
    public const SEND_OTP_SMS = 'sms/send/otp';
    public const SENDER_NAME = 'sms/header';
    public const DEFAULT_SEND_GET_SMS = 'https://api.netgsm.com.tr/sms/send/get';

    /**
     * @param string  $path
     *
     * @return string
     */
    public static function getUrl(string $path): string
    {
        return self::$base_url . $path;
    }
}

