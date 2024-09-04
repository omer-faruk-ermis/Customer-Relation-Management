<?php

namespace App\Utils;

use Exception;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Class StringUtil
 *
 * @package App\Utils
 */
final class StringUtil
{
    /**
     * Transform a SimpleXMLElement to a JSON object.
     *
     * @param $element
     *
     * @return string
     */
    public static function elementToJson($element): string
    {
        return json_encode($element);
    }

    /**
     * Transform an array to a JSON object.
     *
     * @param array      $array
     * @param array|int  $options Options from https://www.php.net/manual/en/json.constants.php
     *
     * @return string
     */
    public static function arrayToJson(array $array, array|int $options = 0x00): string
    {
        if (is_array($options)) {
            $flags = 0x00;
            foreach ($options as $option) {
                $flags |= $option;
            }
        } else {
            $flags = $options;
        }

        return json_encode($array, $flags);
    }

    /**
     * Transform a JSON string to an array.
     *
     * @param string $string
     *
     * @return array
     */
    public static function jsonToArray(string $string): array
    {
        return self::decodeJson($string, true);
    }

    /**
     * Transform a JSON string to an object.
     *
     * @param string $string
     *
     * @return mixed
     */
    public static function jsonToObject(string $string): mixed
    {
        return self::decodeJson($string, false);
    }

    /**
     * Decode a JSON string.
     * This function only works with UTF-8 encoded strings.
     *
     * @param string $string  The json string being decoded.
     * @param bool   $isArray When <b>TRUE</b>, returned objects will be converted into associative arrays
     *
     * @return mixed
     */
    private static function decodeJson(string $string, bool $isArray): mixed
    {
        static $jsonErrors = [
          JSON_ERROR_DEPTH          => 'JSON_ERROR_DEPTH', // Maximum stack depth exceeded
          JSON_ERROR_STATE_MISMATCH => 'JSON_ERROR_STATE_MISMATCH', // Underflow or the modes mismatch
          JSON_ERROR_CTRL_CHAR      => 'JSON_ERROR_CTRL_CHAR', // Unexpected control character found
          JSON_ERROR_SYNTAX         => 'JSON_ERROR_SYNTAX', // Syntax error, malformed JSON
          JSON_ERROR_UTF8           => 'JSON_ERROR_UTF8', // Malformed UTF-8 characters, possibly incorrectly encoded
        ];

        $data = json_decode($string, $isArray);

        if (JSON_ERROR_NONE !== json_last_error()) {
            $last = json_last_error();
            throw new RuntimeException(
              'Unable to parse JSON data: ' . ($jsonErrors[$last] ?? 'UNKNOWN_ERROR')
            );
        }

        return $data;
    }

    /**
     * Determine if the given string is json or not.
     *
     * @param $string
     *
     * @return bool
     */
    public static function isValidJson($string): bool
    {
        try {
            $data = self::jsonToArray($string);
        } catch (Exception $exception) {
            return false;
        }

        return !empty($data);
    }

    /**
     * Insert the given value between one thing and another.
     *
     * @param string $value
     * @param string $prefix
     * @param string $suffix
     *
     * @return string
     */
    public static function interpose(string $value, string $prefix, string $suffix): string
    {
        return Str::start(Str::finish($value, $suffix), $prefix);
    }

    /**
     * Perform a regular expression match.
     *
     * @param string      $pattern
     * @param string|null $subject
     *
     * @return bool
     */
    public static function checkRegex(string $pattern, ?string $subject): bool
    {
        return !empty($subject) && preg_match($pattern, $subject);
    }

    /**
     * Transform Snake Case
     *
     * @param string  $key
     *
     * @return string
     */
    public static function snake(string $key): string
    {
        return Str::lower(str_replace(' ', '_', trim($key)));
    }
}
