<?php

namespace App\Services\WebPortal;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\AuthorizationUserType;
use App\Enums\Authorization\SmsManagement;
use App\Enums\DefaultConstant;
use App\Enums\Status;
use App\Exceptions\WebPortal\WebPortalAuthorizationPermissionNotFoundException;
use App\Helpers\CacheOperation;
use App\Models\WebPortal\WebPortalYetkiIzin;
use App\Services\AbstractService;
use App\Utils\Security;
use Exception;
use Illuminate\Http\Request;

/**
 * Class WebPortalAuthorizationPermissionService
 *
 * @package App\Service\WebPortal
 */
class WebPortalAuthorizationPermissionService extends AbstractService
{
    protected array $serviceAuthorizations = [
        AuthorizationTypeName::SMS_MANAGEMENT => [
            SmsManagement::AUTHORIZED_GROUPS,
            SmsManagement::AUTHORIZED_GROUPS_GROUP,
            SmsManagement::APP_MANAGEMENT,
            SmsManagement::APP_EMPLOYEE
        ]
    ];

    /**
     * @param Request  $request
     *
     * @return WebPortalYetkiIzin
     * @throws Exception
     */
    public function store(Request $request): WebPortalYetkiIzin
    {
        $webPortalAuthorizationPermission = WebPortalYetkiIzin::create([
                                                                           'userid'   => $request->input('employee_id'),
                                                                           'yetki_id' => $request->input('authorization_id'),
                                                                           'durum'    => Status::ACTIVE,
                                                                           'usermi'   => AuthorizationUserType::AGENT,
                                                                           'tarih'    => now()->format(DefaultConstant::DEFAULT_DATETIME_FORMAT),
                                                                       ]);
        CacheOperation::setSession($request);

        return $webPortalAuthorizationPermission;
    }

    /**
     * @param string  $id
     *
     * @return void
     * @throws WebPortalAuthorizationPermissionNotFoundException
     * @throws Exception
     */
    public function destroy(string $id): void
    {
        $webPortalAuthorizationPermission = WebPortalYetkiIzin::find(Security::decrypt($id));
        if (empty($webPortalAuthorizationPermission)) {
            throw new WebPortalAuthorizationPermissionNotFoundException();
        }

        $webPortalAuthorizationPermission->durum = Status::PASSIVE;
        $webPortalAuthorizationPermission->update();

        CacheOperation::setSession($this->request);
    }
}
