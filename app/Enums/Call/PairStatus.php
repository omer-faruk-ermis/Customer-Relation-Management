<?php

namespace App\Enums\Call;

use App\Enums\AbstractEnum;

class PairStatus extends AbstractEnum
{
    public const ALL = '*';
    public const UNPAIRED = 0;
    public const PAIRED = 1;

    public static function values(): array
    {
        return [
            'Tümü'            => self::ALL,
            'Eşleştirilmemiş' => self::UNPAIRED,
            'Eşleştirilmiş'   => self::PAIRED
        ];
    }
}
