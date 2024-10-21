<?php

namespace App\Services\Strategies;

use App\Constants\Route;
use App\Enums\Authorization\AuthorizationTypeName;
use App\Exceptions\ForbiddenException;
use App\Utils\RouteUtil;
use Illuminate\Http\Request;

class GeneralAuthorizationStrategy implements PermissionStrategy
{
    protected array $privateMethods;
    protected string $method;

    public function __construct(array $privateMethods, string $method)
    {
        $this->privateMethods = $privateMethods;
        $this->method = $method;
    }

    /**
     * @param Request  $request
     * @param array    $authorizationIds
     * @param array    $authorizations
     *
     * @return bool
     * @throws ForbiddenException
     */
    public function check(Request $request, array $authorizationIds, array $authorizations): bool
    {
        if (RouteUtil::currentPath() !== Route::WIDGET || RouteUtil::currentPath() !== Route::WIDGET_WITH_SLASH) {
            return true;
        }

        if (in_array($this->method, array_keys($this->privateMethods))) {
            if (!empty($authorizationIds)) {
                if (!empty(array_intersect($authorizationIds[AuthorizationTypeName::AUTHORIZATION], [$this->privateMethods[$this->method]]))) {
                    return true;
                }

                throw new ForbiddenException();
            }

            throw new ForbiddenException();
        }

        throw new ForbiddenException();
    }
}
