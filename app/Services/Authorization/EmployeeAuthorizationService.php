<?php

namespace App\Services\Authorization;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\Method;
use App\Enums\Status;
use App\Exceptions\Authorization\EmployeeAuthorizationNotFoundException;
use App\Exceptions\Employee\EmployeeAuthorizationAlreadyHaveException;
use App\Helpers\CacheOperation;
use App\Models\Authorization\SmsKimlikYetki;
use App\Services\AbstractService;
use App\Services\BulkAuthorizationTrait;
use App\Utils\RouteUtil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class EmployeePermissionService
 *
 * @package App\Service\Authorization
 */
class EmployeeAuthorizationService extends AbstractService
{
    use BulkAuthorizationTrait;

    protected array $serviceAuthorizations = [
        AuthorizationTypeName::SMS_MANAGEMENT => [
            SmsManagement::AUTHORIZED_GROUPS,
            SmsManagement::AUTHORIZED_GROUPS_GROUP,
            SmsManagement::APP_MANAGEMENT,
            SmsManagement::APP_EMPLOYEE
        ],
    ];

    /**
     * @param Request  $request
     *
     * @return void
     * @throws Exception
     */
    public function store(Request $request): void
    {
        $webPortalAuthorizationPermission = SmsKimlikYetki::where('url_id', '=', $request->input('authorization_id'))
                                                          ->where('sms_kimlik', '=', $request->input('employee_id'))
                                                          ->active()
                                                          ->first();

        if ($webPortalAuthorizationPermission) {
            throw new EmployeeAuthorizationAlreadyHaveException();
        }

        SmsKimlikYetki::create([
                                   'sms_kimlik' => $request->input('employee_id'),
                                   'url_id'     => $request->input('authorization_id'),
                                   'durum'      => Status::ACTIVE,
                                   'kayit_id'   => Auth::id(),
                                   'kayit_ip'   => $request->ip(),
                               ]);

        if (Method::STORE === RouteUtil::currentRoute())
            CacheOperation::setSession($request);
    }

    /**
     * @param Request  $request
     *
     * @return void
     * @throws EmployeeAuthorizationNotFoundException
     * @throws Exception
     */
    public function destroy(Request $request): void
    {
        $employeeAuthorization = SmsKimlikYetki::where('url_id', '=', $request->input('authorization_id'))
                                               ->where('sms_kimlik', '=', $request->input('employee_id'))
                                               ->when(Method::DESTROY === RouteUtil::currentRoute(), function ($q) {
                                                   $q->active();
                                               })
                                               ->first();

        if (empty($employeeAuthorization)) {
            throw new EmployeeAuthorizationNotFoundException();
        }

        $employeeAuthorization->durum = Status::PASSIVE;
        $employeeAuthorization->update();
        if (Method::DESTROY === RouteUtil::currentRoute())
            CacheOperation::setSession($this->request);
    }
}
