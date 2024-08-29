<?php

namespace App\Services\Authorization;

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

    /**
     * @param Request  $request
     *
     * @return void
     * @throws Exception
     */
    public function store(Request $request): void
    {
        $employeeAuthorizationPermission = SmsKimlikYetki::where('url_id', '=', $request->input('authorization_id'))
                                                         ->where('sms_kimlik', '=', $request->input('employee_id'))
                                                         ->first();

        if ($employeeAuthorizationPermission && $employeeAuthorizationPermission->durum == Status::ACTIVE) {
            if (Method::STORE === RouteUtil::currentRoute()) {
                throw new EmployeeAuthorizationAlreadyHaveException();
            } else {
                return;
            }
        }

        if ($employeeAuthorizationPermission && $employeeAuthorizationPermission->durum != Status::ACTIVE) {
            self::update($request, $employeeAuthorizationPermission->id);
            return;
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
     * @param int      $id
     *
     * @return SmsKimlikYetki
     * @throws EmployeeAuthorizationNotFoundException
     */
    public function update(Request $request, int $id): SmsKimlikYetki
    {
        $employeeAuthorizationPermission = SmsKimlikYetki::find($id);
        if (empty($employeeAuthorizationPermission)) {
            throw new EmployeeAuthorizationNotFoundException();
        }

        $employeeAuthorizationPermission->durum = Status::ACTIVE;
        $employeeAuthorizationPermission->update();

        return $employeeAuthorizationPermission;
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
        $employeeAuthorizationPermission = SmsKimlikYetki::where('url_id', '=', $request->input('authorization_id'))
                                                         ->where('sms_kimlik', '=', $request->input('employee_id'))
                                                         ->when(Method::DESTROY === RouteUtil::currentRoute(), function ($q) {
                                                             $q->active();
                                                         })
                                                         ->first();

        if (empty($employeeAuthorizationPermission)) {
            throw new EmployeeAuthorizationNotFoundException();
        }

        $employeeAuthorizationPermission->durum = Status::PASSIVE;
        $employeeAuthorizationPermission->update();

        if (Method::DESTROY === RouteUtil::currentRoute())
            CacheOperation::setSession($this->request);
    }
}
