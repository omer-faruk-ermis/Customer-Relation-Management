<?php

namespace App\Services;

use App\Exceptions\ForbiddenException;
use App\Services\Authorization\AuthorizationService;
use App\Services\Strategies\BlueScreenStrategy;
use App\Services\Strategies\GeneralAuthorizationStrategy;
use App\Services\Strategies\SmsManagementStrategy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class PermissionService
{
    /**
     * @throws ForbiddenException
     */
    public function __construct(Request $request, array $serviceAuthorizations, array $privateMethods, array $publicMethods)
    {
        $method = explode('@', Route::current()->getAction()['controller'])[1];
        if (in_array($method, $publicMethods, true) || empty($serviceAuthorizations)) {
            return;
        }

        $authorizationIds = AuthorizationService::parseAuthorizationString(Auth::user()?->yetki_string);
        $strategies = [
            new SmsManagementStrategy(),
            new BlueScreenStrategy(),
            new GeneralAuthorizationStrategy($privateMethods, $method),
        ];

        foreach ($strategies as $strategy) {
            $strategy->check($request, $authorizationIds, $serviceAuthorizations);
        }
    }
}
