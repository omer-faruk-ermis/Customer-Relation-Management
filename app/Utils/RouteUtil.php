<?php

namespace App\Utils;

use Illuminate\Support\Facades\Route;

/**
 * Class RouteUtil
 *
 * @package App\Utils
 */
final class RouteUtil
{
    /**
     * @return string
     */
    public static function currentRoute(): string
    {
        return explode('@', Route::current()->getAction()['controller'])[1];
    }
}
