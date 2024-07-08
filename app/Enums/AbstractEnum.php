<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use ReflectionClass;

/**
 * Abstract class AbstractEnum
 *
 * @package App\Enums
 */
abstract class AbstractEnum extends Enum
{
    /**
     * @param $value
     *
     * @return bool
     */
    public static function hasValues($value): bool
    {
        return !empty(array_intersect($value, (new ReflectionClass(static::class))->getConstants()));
    }
}
