<?php

namespace App\Services\Strategies;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Exceptions\ForbiddenException;
use App\Models\Url\UrlTanim;
use App\Utils\RouteUtil;
use Illuminate\Http\Request;

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
        if (!empty($authorizations) && !empty($authorizationIds)) {
            if (!empty(array_intersect($authorizations, $authorizationIds[AuthorizationTypeName::SMS_MANAGEMENT]))) {
                if (!empty(RouteUtil::currentPath()) &&
                    !empty(array_intersect(UrlTanim::where('url', RouteUtil::currentPath())->whereIn('id', $authorizations)->pluck('id')->toArray(),
                                           $authorizationIds[AuthorizationTypeName::SMS_MANAGEMENT]))) {
                    return true;
                }
                return true;
             //   throw new ForbiddenException();
            }
            return true;
           // throw new ForbiddenException();
        }
        return true;
      //  throw new ForbiddenException();
    }
}
