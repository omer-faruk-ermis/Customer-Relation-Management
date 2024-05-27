<?php

namespace App\Services\Strategies;

use App\Enums\Authorization\Authorization;
use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\AuthorizationUserType;
use App\Enums\Status;
use App\Exceptions\ForbiddenException;
use App\Models\WebPortal\WebPortalYetki;
use App\Models\WebPortal\WebPortalYetkiIzin;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

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
        if (Arr::get($authorizations, AuthorizationTypeName::AUTHORIZATION) && !empty($authorizationIds)) {
            if (Authorization::hasValue($authorizations[AuthorizationTypeName::AUTHORIZATION])
                && !empty(array_intersect($authorizations[AuthorizationTypeName::AUTHORIZATION], $authorizationIds[AuthorizationTypeName::AUTHORIZATION]))) {

                $process = WebPortalYetki::where('aciklama', $request->input('process'))
                                         ->whereIn('id', $authorizations[AuthorizationTypeName::AUTHORIZATION])
                                         ->where('durum', Status::ACTIVE)
                                         ->first();

                if ($process && WebPortalYetkiIzin::where('yetki_id', $process->id)
                                                  ->where('userid', Auth::id())
                                                  ->where('usermi', AuthorizationUserType::AGENT)
                                                  ->where('durum', Status::ACTIVE)
                                                  ->exists()) {
                    return true;
                }
            }

            throw new ForbiddenException();
        }

        return true;
    }
}
