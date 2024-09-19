<?php

namespace App\Utils;

use App\Enums\RegexPattern;
use App\Exceptions\InvalidParameterException;
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
        if (is_array($value)) return $value;

        if (is_string($value)) {
            $decodedValue = json_decode($value, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decodedValue)) {
                return $decodedValue;
            }
            $value = self::stringArrayToArray($value);

            return Arr::wrap($value);
        }

        return Arr::wrap($value);
    }

    /**
     * @param $value
     *
     * @return array|null
     * @throws InvalidParameterException
     */
    public static function numericalCommaToArray($value): array|null
    {
        if (empty($value)) {
            return null;
        }

        if (str_contains($value, ',')) {
            return Arr::wrap(array_filter(array_map('trim', explode(',', $value))));
        }
        else if(is_numeric($value)) {
            return Arr::wrap($value);
        }

        throw new InvalidParameterException();
    }

    /**
     * Transform to real array value of array from kind of string.
     *
     * @param $value
     *
     * @return array|string
     */
    private static function stringArrayToArray($value): array|string
    {
        if (preg_match(RegexPattern::ARRAY_CHECK, $value)) {
            $trimmedString = trim($value, '[]');
            return preg_split(RegexPattern::COMMA_SPLIT, $trimmedString);
        }

        return $value;
    }
}
