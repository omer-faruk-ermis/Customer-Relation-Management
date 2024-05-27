<?php

namespace App\Enums;

use ReflectionClass;

/**
 * Abstract class AbstractEnum
 *
 * @package App\Enums
 */
abstract class AbstractEnum
{
    /**
     * @param $value
     *
     * @return bool
     */
    public static function hasValue($value): bool
    {
        return !empty(array_intersect($value, (new ReflectionClass(static::class))->getConstants()));
    }
}
