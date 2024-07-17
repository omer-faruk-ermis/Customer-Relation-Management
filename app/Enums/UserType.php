<?php

namespace App\Enums;

class UserType extends AbstractEnum implements EnumInterface
{
    public const ALL = '*';
    public const CUSTOMER = 0;
    public const SUBSCRIBER = 1;

    public static function values(): array
    {
        return [
            'Tümü'    => self::ALL,
            'Müşteri' => self::CUSTOMER,
            'Abone'   => self::SUBSCRIBER
        ];
    }
}
