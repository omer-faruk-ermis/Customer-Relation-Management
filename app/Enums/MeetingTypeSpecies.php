<?php

namespace App\Enums;

class MeetingTypeSpecies extends AbstractEnum
{
    public const MEETING_DETAIL = [10,2,11,3];

    public static function values(): array
    {
        return [
            'meeting_detail' => self::MEETING_DETAIL,
        ];
    }
}
