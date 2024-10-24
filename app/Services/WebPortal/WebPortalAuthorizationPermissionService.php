<?php

namespace App\Services\WebPortal;

use App\Enums\Authorization\AuthorizationUserType;
use App\Enums\Method;
use App\Enums\Status;
use App\Exceptions\WebPortal\WebPortalAuthorizationPermissionAlreadyHaveException;
use App\Exceptions\WebPortal\WebPortalAuthorizationPermissionNotFoundException;
use App\Helpers\CacheOperation;
use App\Models\WebPortal\WebPortalYetkiIzin;
use App\Services\AbstractService;
use App\Services\BulkAuthorizationTrait;
use App\Utils\DateUtil;
use App\Utils\RouteUtil;
use Exception;
use Illuminate\Http\Request;

/**
 * Class WebPortalAuthorizationPermissionService
 *
 * @package App\Service\WebPortal
 */
class WebPortalAuthorizationPermissionService extends AbstractService
{
    use BulkAuthorizationTrait;

    /**
     * @param Request  $request
     *
     * @return void
     * @throws Exception
     */
    public function store(Request $request): void
    {
        $webPortalAuthorizationPermission = WebPortalYetkiIzin::where('yetki_id', '=', $request->input('authorization_id'))
                                                              ->where('userid', '=', $request->input('employee_id'))
                                                              ->first();

        if ($webPortalAuthorizationPermission && $webPortalAuthorizationPermission->durum == Status::ACTIVE) {
            if (Method::STORE === RouteUtil::currentRoute()) {
                throw new WebPortalAuthorizationPermissionAlreadyHaveException();
            } else {
                return;
            }
        }

        if ($webPortalAuthorizationPermission && $webPortalAuthorizationPermission->durum != Status::ACTIVE) {
            $webPortalAuthorizationPermission->durum = Status::ACTIVE;
            $webPortalAuthorizationPermission->update();
            return;
        }

        WebPortalYetkiIzin::create([
                                       'userid'   => $request->input('employee_id'),
                                       'yetki_id' => $request->input('authorization_id'),
                                       'durum'    => Status::ACTIVE,
                                       'usermi'   => AuthorizationUserType::AGENT,
                                       'tarih'    => DateUtil::now(),
                                   ]);

        if (Method::STORE === RouteUtil::currentRoute())
            CacheOperation::refreshEmployeeSession($request->bearerToken());
    }

    /**
     * @param Request  $request
     *
     * @return void
     * @throws WebPortalAuthorizationPermissionNotFoundException
     * @throws Exception
     */
    public function destroy(Request $request): void
    {
        $webPortalAuthorizationPermission = WebPortalYetkiIzin::where('yetki_id', '=', $request->input('authorization_id'))
                                                              ->where('userid', '=', $request->input('employee_id'))
                                                              ->when(Method::DESTROY === RouteUtil::currentRoute(), function ($q) {
                                                                  $q->active();
                                                              })
                                                              ->first();

        if (empty($webPortalAuthorizationPermission)) {
            throw new WebPortalAuthorizationPermissionNotFoundException();
        }

        $webPortalAuthorizationPermission->durum = Status::PASSIVE;
        $webPortalAuthorizationPermission->update();

        if (Method::DESTROY === RouteUtil::currentRoute())
            CacheOperation::refreshEmployeeSession($request->bearerToken());
    }
}
