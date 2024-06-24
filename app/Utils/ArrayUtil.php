<?php

namespace App\Utils;

use Exception;
use Illuminate\Support\Arr;

/**
 * Class ArrayUtil
 *
 * @package App\Utils
 */
final class ArrayUtil
{
    /**
     * Cast to an array for string or stringArray params
     *
     * @param $value
     *
     * @return string|array
     */
    public static function castArray($value): string|array
    {
        if (is_string($value)) {
            $decodedValue = json_decode($value, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decodedValue)) {
                return $decodedValue;
            } else {
                return Arr::wrap($value);
            }
        } else {
            return Arr::wrap($value);
        }
    }
}
