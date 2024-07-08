<?php

namespace App\Services\Strategies;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Exceptions\ForbiddenException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SmsManagementStrategy implements PermissionStrategy
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
        if (Arr::get($authorizations, AuthorizationTypeName::SMS_MANAGEMENT) && !empty($authorizationIds)) {
            if (SmsManagement::hasValues(Arr::get($authorizations, AuthorizationTypeName::SMS_MANAGEMENT))
                && !empty(array_intersect($authorizations[AuthorizationTypeName::SMS_MANAGEMENT], $authorizationIds[AuthorizationTypeName::SMS_MANAGEMENT]))) {
                return true;
            }

            throw new ForbiddenException();
        }

        return true;
    }
}
