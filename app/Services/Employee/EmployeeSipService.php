<?php

namespace App\Services\Employee;

use App\Enums\NumericalConstant;
use App\Exceptions\Employee\EmployeeSipNotFoundException;
use App\Http\Requests\Employee\IndexEmployeeSipRequest;
use App\Http\Requests\Employee\StoreEmployeeSipRequest;
use App\Models\SmsKimlik\SmsKimlikSip;
use App\Services\AbstractService;
use App\Utils\Security;
use Exception;
use Illuminate\Support\Collection;

/**
 * Class EmployeeSipService
 *
 * @package App\Service\Employee
 */
class EmployeeSipService extends AbstractService
{
    /**
     * @param IndexEmployeeSipRequest  $request
     *
     * @return Collection
     */
    public function index(IndexEmployeeSipRequest $request): Collection
    {
        return SmsKimlikSip::get();
    }

    /**
     * @param StoreEmployeeSipRequest  $request
     *
     * @return SmsKimlikSip
     * @throws Exception
     */
    public function store(StoreEmployeeSipRequest $request): SmsKimlikSip
    {
        return SmsKimlikSip::create([
                                        'sms_kimlik'    => $request->input('employee_id'),
                                        'sip_id'        => $request->input('sip'),
                                        'mesajgitmesin' => $request->input('not_send_message', NumericalConstant::ZERO),
                                    ]);
    }

    /**
     * @param string  $id
     *
     * @return void
     * @throws EmployeeSipNotFoundException
     */
    public function destroy(string $id): void
    {
        $employeeSip = SmsKimlikSip::find(Security::decrypt($id));
        if (empty($employeeSip)) {
            throw new EmployeeSipNotFoundException();
        }

        $employeeSip->delete();
    }
}
