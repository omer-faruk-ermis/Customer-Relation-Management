<?php

namespace App\Enums\Authorization;

use App\Enums\AbstractEnum;

class AuthorizationType extends AbstractEnum
{
    public const SMS_MANAGEMENT = 1;
    public const BLUE_SCREEN = 2;
    public const AUTHORIZATION = 3;
    public const SUBSCRIBER_BILLET = 4;

    public static function values(): array
    {
        return [
            'sms_management'    => self::SMS_MANAGEMENT,
            'blue_screen'       => self::SMS_MANAGEMENT,
            'authorization'     => self::SMS_MANAGEMENT,
            'subscriber_billet' => self::SMS_MANAGEMENT,
        ];
    }
}

