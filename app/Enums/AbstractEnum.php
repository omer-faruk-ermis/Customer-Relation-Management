<?php

namespace App\Enums;

use App\Traits\LocalizableTrait;
use App\Utils\StringUtil;
use Illuminate\Support\Collection;
use ReflectionClass;

/**
 * Abstract class AbstractEnum
 *
 * @package App\Enums
 */
abstract class AbstractEnum
{
    use LocalizableTrait;

    /**
     * Gets all enum values with localization.
     *
     * @return Collection The collection of enum values with translations.
     */
    public static function all(): Collection
    {
        $constants = (new ReflectionClass(static::class))->getConstants();

        return collect($constants)->map(function ($value, $key) {
            $snakeKey = StringUtil::snake($key);

            return (object) [
                'id' => $value,
                'key' => $snakeKey,
                'label' => static::getTranslation($snakeKey . '.label'),
                'description' => static::getTranslation($snakeKey . '.description'),
                'value' => $value,
            ];
        })->values();
    }

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
