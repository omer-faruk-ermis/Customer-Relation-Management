<?php

namespace App\Services\Strategies;

use App\Enums\Authorization\Authorization;
use App\Enums\Authorization\AuthorizationTypeName;
use App\Exceptions\ForbiddenException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
        if (in_array($this->method, $this->privateMethods)) {
            if (Arr::get($authorizations, AuthorizationTypeName::AUTHORIZATION) && !empty($authorizationIds)) {
                if (Authorization::hasValue($authorizations[AuthorizationTypeName::AUTHORIZATION])
                    && !empty(array_intersect($authorizations[AuthorizationTypeName::AUTHORIZATION], $authorizationIds[AuthorizationTypeName::AUTHORIZATION]))) {
                    return true;
                }

                throw new ForbiddenException();
            }

            return true;
        }

        return true;
    }
}
