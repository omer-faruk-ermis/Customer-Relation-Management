<?php

namespace App\Services\Authorization;

use App\Enums\Status;
use App\Exceptions\Authorization\EmployeeAuthorizationNotFoundException;
use App\Models\Authorization\SmsKimlikYetki;
use App\Utils\Security;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Class EmployeePermissionService
 *
 * @package App\Service\Authorization
 */
class EmployeeAuthorizationService
{
    /**
     * @param Request  $request
     *
     * @return void
     */
    public function store(Request $request): void
    {
        SmsKimlikYetki::create([
                                   'sms_kimlik' => $request->input('employee_id'),
                                   'url_id'     => $request->input('url_id'),
                                   'durum'      => Status::ACTIVE,
                                   'kayit_id'   => Cache::get("sms_kimlik_$request->input('netgsmsessionid')"),
                                   'kayit_ip'   => $request->ip(),
                               ]);
    }

    /**
     * @param string  $id
     *
     * @return void
     * @throws EmployeeAuthorizationNotFoundException
     */
    public function destroy(string $id): void
    {
        $employeeAuthorization = SmsKimlikYetki::find(Security::decrypt($id));
        if (empty($employeeAuthorization)) {
            throw new EmployeeAuthorizationNotFoundException();
        }

        $employeeAuthorization->durum = Status::PASSIVE;
        $employeeAuthorization->update();
    }
}
