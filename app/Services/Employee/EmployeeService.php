<?php

namespace App\Services\Employee;

use App\Enums\DefaultConstant;
use App\Enums\NumericalConstant;
use App\Enums\Status;
use App\Exceptions\Employee\EmployeeNotFoundException;
use App\Http\Requests\Employee\BasicEmployeeRequest;
use App\Http\Requests\Employee\ChangePasswordEmployeeRequest;
use App\Http\Requests\Employee\IndexEmployeeRequest;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\StoreEmployeeSipRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\SmsKimlik\SmsKimlik;
use App\Services\Log\LogService;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class EmployeeService
 *
 * @package App\Service\Employee
 */
class EmployeeService
{
    /**
     * @param IndexEmployeeRequest  $request
     *
     * @return mixed
     */
    public function index(IndexEmployeeRequest $request): mixed
    {
        return SmsKimlik::with(['unit', 'sip'])
            ->filter($request->all())
            ->where('durum', '=', Status::ACTIVE)
            ->paginate(DefaultConstant::PAGINATE);
    }

    /**
     * @param BasicEmployeeRequest $request
     *
     * @return Collection
     */
    public function basic(BasicEmployeeRequest $request): Collection
    {
        return SmsKimlik::select(['id', 'ad_soyad'])
            ->limit(DefaultConstant::SEARCH_LIST_LIMIT)
            ->get();
    }

    /**
     * @param Request  $request
     *
     * @return mixed
     */
    public function log(Request $request): mixed
    {
        return (new LogService())->index($request);
    }

    /**
     * @param int  $id
     *
     * @return Model
     * @throws EmployeeNotFoundException
     */
    public function show(int $id): Model
    {
        $smsKimlik = SmsKimlik::with(['unit', 'sip'])->find($id);

        if (empty($smsKimlik)) {
            throw new EmployeeNotFoundException();
        }

        return $smsKimlik;
    }

    /**
     * @param StoreEmployeeRequest $request
     * @return SmsKimlik
     * @throws Exception
     */
    public function store(StoreEmployeeRequest $request): SmsKimlik
    {
        $smsKimlik = SmsKimlik::create([
            'ad_soyad'                  => $request->input('full_name'),
            'sifre'                     => $request->input('password'),
            'loginpage'                 => $request->input('login_permission'),
            'birim_id'                  => $request->input('unit'),
            'para_limit'                => $request->input('currency_limit'),
            'ceptel'                    => $request->input('mobile_phone'),
            'sms_kimlik_email'          => $request->input('email'),
            'sms_kimlik_email_username' => $request->input('username'),
            'sms_kimlik_email_password' => $request->input('email_password'),
            'evtel'                     => $request->input('home_phone')
        ]);

        $sipRequest = new StoreEmployeeSipRequest([
            'sip'              => $request->input('sip'),
            'sms_kimlik'       => $smsKimlik->id,
            'not_send_message' => $request->input('not_send_message', NumericalConstant::ZERO)
        ]);

        (new EmployeeSipService)->store($sipRequest);

        return $smsKimlik;
    }

    /**
     * @param UpdateEmployeeRequest $request
     * @param int $id
     * @return SmsKimlik
     * @throws EmployeeNotFoundException
     */
    public function update(UpdateEmployeeRequest $request, int $id): SmsKimlik
    {
        $smsKimlik = SmsKimlik::find($id);
        if (empty($smsKimlik)) {
            throw new EmployeeNotFoundException();
        }

        $smsKimlik->update([
            'ad_soyad'                  => $request->input('full_name'),
            'loginpage'                 => $request->input('login_permission'),
            'birim_id'                  => $request->input('unit'),
            'para_limit'                => $request->input('currency_limit'),
            'ceptel'                    => $request->input('mobile_phone'),
            'sms_kimlik_email'          => $request->input('email'),
            'sms_kimlik_email_username' => $request->input('username'),
            'sms_kimlik_email_password' => $request->input('email_password'),
            'evtel'                     => $request->input('home_phone'),
        ]);

        return $smsKimlik;
    }

    /**
     * @param ChangePasswordEmployeeRequest $request
     * @param int $id
     * @return void
     * @throws EmployeeNotFoundException
     */
    public function changePassword(ChangePasswordEmployeeRequest $request, int $id): void
    {
        $smsKimlik = SmsKimlik::find($id);
        if (empty($smsKimlik)) {
            throw new EmployeeNotFoundException();
        }

        $smsKimlik->update(['sifre' => $request->input('new_password')]);
    }

    /**
     * @param int $id
     * @return void
     * @throws EmployeeNotFoundException
     */
    public function destroy(int $id): void
    {
        $smsKimlik = SmsKimlik::find($id);
        if (empty($smsKimlik)) {
            throw new EmployeeNotFoundException();
        }

        $smsKimlik->durum = Status::PASSIVE;
        $smsKimlik->update();
    }
}
