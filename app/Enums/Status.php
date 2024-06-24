<?php

namespace App\Enums;

class Status implements EnumInterface
{
    const ACTIVE = 1;
    const PASSIVE = 0;

    public static function values(): array
    {
        return [
            'Aktif' => self::ACTIVE,
            'Pasif' => self::PASSIVE
        ];
    }
}
