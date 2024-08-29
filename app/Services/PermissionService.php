<?php

namespace App\Services;

use App\Exceptions\ForbiddenException;
use App\Services\Authorization\AuthorizationService;
use App\Services\Strategies\BlueScreenStrategy;
use App\Services\Strategies\GeneralAuthorizationStrategy;
use App\Services\Strategies\SmsManagementStrategy;
use App\Utils\RouteUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class PermissionService
 *
 * @package App\Service
 */
class PermissionService
{
    /**
     * @throws ForbiddenException
     */
    public function __construct(Request $request, string $serviceName, array $privateMethods, array $publicMethods)
    {
        $matchingItems = array_filter(array_map(function ($item) use ($serviceName) {
            return $item->name === $serviceName ? $item->page_id : null;
        }, Auth::user()?->service_authorizations?->toArray() ?? []));

        $method = RouteUtil::currentRoute();
        if (in_array($method, $publicMethods)) {
            return;
        }

        $authorizationIds = AuthorizationService::parseAuthorizationString(Auth::user()?->yetki_string);
        $strategies = [
            new SmsManagementStrategy(),
            //new BlueScreenStrategy(),
            new GeneralAuthorizationStrategy($privateMethods, $method),
        ];

        foreach ($strategies as $strategy) {
            $strategy->check($request, $authorizationIds, $matchingItems);
        }
    }
}
