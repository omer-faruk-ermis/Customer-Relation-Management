<?php

namespace App\Services\Authorization;

use App\Enums\Authorization\AuthorizationTypeName;
use App\Enums\Authorization\SmsManagement;
use App\Enums\Status;
use App\Exceptions\Authorization\EmployeeAuthorizationNotFoundException;
use App\Helpers\CacheOperation;
use App\Http\Requests\Authorization\StoreEmployeeAuthorizationRequest;
use App\Models\Authorization\SmsKimlikYetki;
use App\Services\AbstractService;
use App\Utils\Security;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * Class EmployeePermissionService
 *
 * @package App\Service\Authorization
 */
class EmployeeAuthorizationService extends AbstractService
{
    protected array $serviceAuthorizations = [
        AuthorizationTypeName::SMS_MANAGEMENT => [
            SmsManagement::AUTHORIZED_GROUPS,
            SmsManagement::AUTHORIZED_GROUPS_GROUP,
            SmsManagement::APP_MANAGEMENT,
            SmsManagement::APP_EMPLOYEE
        ],
    ];

    /**
     * @param StoreEmployeeAuthorizationRequest  $request
     *
     * @return void
     * @throws Exception
     */
    public function store(StoreEmployeeAuthorizationRequest $request): void
    {
        SmsKimlikYetki::create([
                                   'sms_kimlik' => $request->input('employee_id'),
                                   'url_id'     => $request->input('url_id'),
                                   'durum'      => Status::ACTIVE,
                                   'kayit_id'   => Auth::id(),
                                   'kayit_ip'   => $request->ip(),
                               ]);

        CacheOperation::setSession($request);
    }

    /**
     * @param string  $id
     *
     * @return void
     * @throws EmployeeAuthorizationNotFoundException
     * @throws Exception
     */
    public function destroy(string $id): void
    {
        $employeeAuthorization = SmsKimlikYetki::find(Security::decrypt($id));
        if (empty($employeeAuthorization)) {
            throw new EmployeeAuthorizationNotFoundException();
        }

        $employeeAuthorization->durum = Status::PASSIVE;
        $employeeAuthorization->update();

        CacheOperation::setSession($this->request);
    }
}
