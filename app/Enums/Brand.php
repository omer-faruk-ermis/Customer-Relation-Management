<?php

namespace App\Enums;

class Brand extends AbstractEnum
{
    public const ALL = '*';
    public const ATB = [1, 4];
    public const TEKNOKENT = [2, 3];

    public static function values(): array
    {
        return [
            'Tümü'      => self::ALL,
            'ATB'       => self::ATB,
            'Teknokent' => self::TEKNOKENT
        ];
    }
}
