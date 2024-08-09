<?php

namespace App\Utils;

use App\Enums\Log;

/**
 * Class LogUtil
 *
 * @package App\Utils
 */
final class LogUtil
{
    /**
     * Give a log message from the log level.
     *
     * @param $level
     *
     * @return string
     */
    public static function level2String($level): string
    {
        switch ($level) {
            case LOG_EMERG:
                return Log::EMERGENCY;
            case LOG_ALERT:
                return Log::ALERT;
            case LOG_CRIT:
                return Log::CRITICAL;
            case LOG_ERR:
                return Log::ERROR;
            case LOG_WARNING:
                return Log::WARNING;
            case LOG_NOTICE:
                return Log::NOTICE;
            case LOG_INFO:
                return Log::INFO;
            case LOG_DEBUG:
                return Log::DEBUG;
        }
    }
}
