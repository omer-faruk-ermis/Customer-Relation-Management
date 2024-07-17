<?php

namespace App\Enums\Call;

use App\Enums\AbstractEnum;
use App\Enums\EnumInterface;

class CallDirection extends AbstractEnum implements EnumInterface
{
    public const ALL = '*';
    public const INCOMING_CALL = 1;
    public const OUTGOING_CALL = 2;

    public static function values(): array
    {
        return [
            'Tümü'        => self::ALL,
            'Gelen Çağrı' => self::INCOMING_CALL,
            'Giden Çağrı' => self::OUTGOING_CALL
        ];
    }
}
