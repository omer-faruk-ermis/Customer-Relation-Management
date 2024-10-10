<?php

namespace App\Services\Employee;

use App\Enums\DefaultConstant;
use App\Enums\Method;
use App\Enums\NumericalConstant;
use App\Enums\Status;
use App\Exceptions\Employee\EmployeeNotFoundException;
use App\Exceptions\Employee\HaveAlreadyEmployeeException;
use App\Exceptions\ForbiddenException;
use App\Http\Requests\Authorization\StoreEmployeeAuthorizationRequest;
use App\Http\Requests\Employee\BasicEmployeeRequest;
use App\Http\Requests\Employee\ChangePasswordEmployeeRequest;
use App\Http\Requests\Employee\IndexEmployeeRequest;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\StoreEmployeeSipRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\SmsKimlik\SmsKimlik;
use App\Services\AbstractService;
use App\Services\Authorization\EmployeeAuthorizationService;
use App\Services\Log\LogService;
use App\Utils\Security;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class EmployeeService
 *
 * @package App\Service\Employee
 */
class EmployeeService extends AbstractService
{
    protected array $publicMethods = [Method::INDEX, Method::BASIC];

    /**
     * @param IndexEmployeeRequest  $request
     *
     * @return mixed
     */
    public function index(IndexEmployeeRequest $request): mixed
    {
        return SmsKimlik::with(['unit', 'sip'])
                        ->filter($request->all())
                        ->active()
                        ->where('loginpage', '=', Status::ACTIVE)
                        ->paginate(DefaultConstant::PAGINATE);
    }

    /**
     * @param BasicEmployeeRequest  $request
     *
     * @return Collection
     */
    public function basic(BasicEmployeeRequest $request): Collection
    {
        return SmsKimlik::select(['id', 'ad_soyad'])
                        ->filter($request->all())
                        ->active()
                        ->where('loginpage', '=', Status::ACTIVE)
                        ->get();
    }

    /**
     * @param Request  $request
     *
     * @return mixed
     * @throws ForbiddenException
     */
    public function log(Request $request): mixed
    {
        return (new LogService($request))->index($request);
    }

    /**
     * @param string  $id
     *
     * @return Model
     * @throws EmployeeNotFoundException
     */
    public function show(string $id): Model
    {
        $employee = SmsKimlik::with(['unit', 'sip'])->find(Security::decrypt($id));
        if (empty($employee)) {
            throw new EmployeeNotFoundException();
        }

        return $employee;
    }

    /**
     * @param StoreEmployeeRequest  $request
     *
     * @return SmsKimlik
     * @throws Exception
     */
    public function store(StoreEmployeeRequest $request): SmsKimlik
    {
        $employee = SmsKimlik::whereNotNull('sms_kimlik_email')
                             ->where('sms_kimlik_email', '=', $request->input('email'))
                             ->active()
                             ->first();

        if (!empty($employee)) {
            throw new HaveAlreadyEmployeeException();
        }

        $newEmployee = SmsKimlik::create([
                                             'ad_soyad'                  => $request->input('full_name'),
                                             'sifre'                     => $request->input('password'),
                                             'loginpage'                 => $request->input('login_permission'),
                                             'birim_id'                  => $request->input('unit'),
                                             'para_limit'                => $request->input('currency_limit'),
                                             'ceptel'                    => $request->input('mobile_phone'),
                                             'sms_kimlik_email'          => $request->input('email'),
                                             'evtel'                     => $request->input('home_phone')
                                         ]);

        $this->storeEmployeeSip($request, $newEmployee->id);
        $this->storeEmployeeAuthorization($request, $newEmployee->id);

        return $newEmployee;
    }

    /**
     * @param UpdateEmployeeRequest  $request
     * @param string                 $id
     *
     * @return SmsKimlik
     * @throws EmployeeNotFoundException
     */
    public function update(UpdateEmployeeRequest $request, string $id): SmsKimlik
    {
        $employee = SmsKimlik::find(Security::decrypt($id));
        if (empty($employee)) {
            throw new EmployeeNotFoundException();
        }

        $employee->update([
                              'ad_soyad'                  => $request->input('full_name', $employee->ad_soyad),
                              'loginpage'                 => $request->input('login_permission', $employee->loginpage),
                              'birim_id'                  => $request->input('unit', $employee->birim_id),
                              'para_limit'                => $request->input('currency_limit', $employee->para_limit),
                              'ceptel'                    => $request->input('mobile_phone', $employee->ceptel),
                              'sms_kimlik_email'          => $request->input('email', $employee->sms_kimlik_email),
                              'evtel'                     => $request->input('home_phone', $employee->evtel),
                          ]);

        return $employee;
    }

    /**
     * @param ChangePasswordEmployeeRequest  $request
     * @param string                         $id
     *
     * @return void
     * @throws EmployeeNotFoundException
     */
    public function changePassword(ChangePasswordEmployeeRequest $request, string $id): void
    {
        $employee = SmsKimlik::find(Security::decrypt($id));
        if (empty($employee)) {
            throw new EmployeeNotFoundException();
        }

        $employee->update(['sifre' => $request->input('new_password')]);
    }

    /**
     * @param string  $id
     *
     * @return void
     * @throws EmployeeNotFoundException
     */
    public function destroy(string $id): void
    {
        $employee = SmsKimlik::find(Security::decrypt($id));
        if (empty($employee)) {
            throw new EmployeeNotFoundException();
        }

        $employee->durum = Status::PASSIVE;
        $employee->update();
    }

    /**
     * @param StoreEmployeeRequest  $request
     * @param int                   $employeeId
     *
     * @return void
     * @throws Exception
     */
    private function storeEmployeeSip(StoreEmployeeRequest $request, int $employeeId): void
    {
        $sipRequest = new StoreEmployeeSipRequest([
                                                      'sip'              => $request->input('sip'),
                                                      'employee_id'      => $employeeId,
                                                      'not_send_message' => $request->input('not_send_message', NumericalConstant::ZERO)
                                                  ]);

        (new EmployeeSipService($sipRequest))->store($sipRequest);
    }

    /**
     * @param StoreEmployeeRequest  $request
     * @param int                   $employeeId
     *
     * @return void
     * @throws ForbiddenException
     * @throws Exception
     */
    private function storeEmployeeAuthorization(StoreEmployeeRequest $request, int $employeeId): void
    {
        $authorizationRequest = new StoreEmployeeAuthorizationRequest([
                                                                          'authorization_id' => DefaultConstant::AUTHORIZATION,
                                                                          'employee_id'      => $employeeId,
                                                                      ]);
        $authorizationRequest->headers->set('Authorization', 'Bearer ' . $request->bearerToken());

        (new EmployeeAuthorizationService($authorizationRequest))->store($authorizationRequest);
    }
}
