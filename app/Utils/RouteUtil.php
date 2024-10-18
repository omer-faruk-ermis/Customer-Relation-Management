<?php

namespace App\Utils;

use Illuminate\Support\Facades\Route;
use App\Constants\Route as ConstantRoute;

/**
 * Class RouteUtil
 *
 * @package App\Utils
 */
final class RouteUtil
{
    /**
     * @return string|null
     */
    public static function currentRoute(): string|null
    {
        return !empty(Route::current()) ? explode('@', Route::current()?->getAction()['controller'])[1] : null;
    }

    /**
     * @return string|null
     */
    public static function currentController(): string|null
    {
        return !empty(Route::current()) ? explode('@', Route::current()->getAction()['controller'])[0] : null;
    }

    /**
     * @return string|null
     */
    public static function currentPath(): string|null
    {
        $path = request()->headers->get('Page-Pathname');

        $basePaths = [
            ConstantRoute::AGENT
        ];

        /** Loop through each base path and check if the current path starts with one of them */
        foreach ($basePaths as $basePath) {
            if (str_starts_with($path, $basePath)) {
                /** Strip off any extra segments after the third segment (base path + 2 more segments) */
                $segments = explode('/', trim($path, '/'));

                return '/' . implode('/', array_slice($segments, 0, 3));
            }
        }

        /** Return the original path*/
        return $path;
    }
}
