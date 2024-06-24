<?php

namespace App\Services\Strategies;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\BlueScreen;
use App\Exceptions\ForbiddenException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BlueScreenStrategy implements PermissionStrategy
{
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
        if (Arr::get($authorizations, AuthorizationTypeName::BLUE_SCREEN) && !empty($authorizationIds)) {
            if (BlueScreen::hasValue(Arr::get($authorizations, AuthorizationTypeName::BLUE_SCREEN))
                && !empty(array_intersect($authorizations[AuthorizationTypeName::BLUE_SCREEN], $authorizationIds[AuthorizationTypeName::BLUE_SCREEN]))) {
                return true;
            }

            throw new ForbiddenException();
        }

        return true;
    }
}
