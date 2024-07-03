<?php

namespace App\Enums;

class ReasonType extends AbstractEnum
{
    public const MEETING_DETAIL = 67;

    public static function values(): array
    {
        return [
            'meeting_detail' => self::MEETING_DETAIL,
        ];
    }
}
