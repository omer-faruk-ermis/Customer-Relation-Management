<?php

namespace App\Utils;

/**
 * Class GitUtil
 *
 * @package App\Utils
 */
final class GitUtil
{
    /**
     * @return string
     */
    public static function getCurrentBranch(): string
    {
        return trim(shell_exec('git branch --show-current'));
    }
}
