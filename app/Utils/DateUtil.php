<?php

namespace App\Utils;

use App\Enums\DefaultConstant;
use Illuminate\Support\Carbon;

/**
 * Class DateUtil
 *
 * @package App\Utils
 */
final class DateUtil
{
    /**
     * @param string|null  $date
     *
     * @return string|null
     */
    public static function dateFormat(?string $date): ?string
    {
        return !empty($date) ? Carbon::parse($date)->format(DefaultConstant::DEFAULT_DATETIME_FORMAT) : null;
    }
}
