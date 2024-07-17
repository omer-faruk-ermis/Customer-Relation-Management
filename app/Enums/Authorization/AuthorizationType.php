<?php

namespace App\Enums\Authorization;

use App\Enums\AbstractEnum;
use App\Enums\EnumInterface;

class AuthorizationType extends AbstractEnum implements EnumInterface
{
    public const SMS_MANAGEMENT = 1;
    public const BLUE_SCREEN = 2;
    public const AUTHORIZATION = 3;
    public const SUBSCRIBER_BILLET = 4;

    public static function values(): array
    {
        return [
            'sms_management'    => self::SMS_MANAGEMENT,
            'blue_screen'       => self::BLUE_SCREEN,
            'authorization'     => self::AUTHORIZATION,
            'subscriber_billet' => self::SUBSCRIBER_BILLET,
        ];
    }
}

