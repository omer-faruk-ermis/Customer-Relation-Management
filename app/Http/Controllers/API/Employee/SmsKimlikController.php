<?php

namespace App\Http\Controllers\API\Employee;

use App\Enums\DefaultConstant;
use App\Enums\NumericalConstant;
use App\Enums\Status;
use App\Exceptions\Employee\EmployeeNotFoundException;
use App\Exceptions\Employee\EmployeeSipNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\BasicEmployeeRequest;
use App\Http\Requests\Employee\ChangePasswordEmployeeRequest;
use App\Http\Requests\Employee\IndexEmployeeRequest;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\StoreEmployeeSipRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Models\SmsKimlik\SmsKimlik;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SmsKimlikController extends Controller
{
    /**
     * @param IndexEmployeeRequest $request
     * @return JsonResponse
     */
    public function index(IndexEmployeeRequest $request): JsonResponse
    {
        return response()->json([
            'message' => true,
            'data'    =>
                SmsKimlik::select('*')
                    ->filter($request->all())
                    ->where('durum', '=', Status::ACTIVE)
                    ->get()
        ], Response::HTTP_OK);
    }

    /**
     * @param BasicEmployeeRequest $request
     * @return JsonResponse
     */
    public function basic(BasicEmployeeRequest $request): JsonResponse
    {
        return response()->json([
            'message' => true,
            'data'    =>
                SmsKimlik::select(['id', 'ad_soyad'])
                    ->limit(DefaultConstant::SEARCH_LIST_LIMIT)
                    ->get()
        ]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws EmployeeNotFoundException
     */
    public function show(int $id): JsonResponse
    {
        $smsKimlik = SmsKimlik::findOrFail($id);

        if (empty($smsKimlik)) {
            return throw new EmployeeNotFoundException();
        }

        return response()->json([
            'message' => true,
            'data'    => $smsKimlik
        ]);
    }

    /**
     * @param StoreEmployeeRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        $smsKimlik = SmsKimlik::create([
            'ad_soyad'                  => $request->input('full_name'),
            'sifre'                     => $request->input('password'),
            'loginpage'                 => $request->input('login_permission'),
            'durum'                     => Status::ACTIVE,
            'yetki_type'                => Status::ACTIVE,
            'karel_id'                  => NumericalConstant::ZERO,
            'esirket_id'                => NumericalConstant::ZERO,
            'sip_id'                    => $request->input('sip'),
            'birim_id'                  => $request->input('unit'),
            'webuserid'                 => NumericalConstant::ZERO,
            'para_limit'                => $request->input('currency_limit'),
            'webportal_izin'            => Status::ACTIVE,
            'ceptel'                    => $request->input('mobile_phone'),
            'sms_kimlik_email'          => $request->input('email'),
            'sms_kimlik_email_username' => $request->input('username'),
            'sms_kimlik_email_password' => $request->input('email_password'),
            'mattermost_id'             => NumericalConstant::ZERO,
            'evtel'                     => $request->input('home_phone'),
            'belge_token'               => null,
        ]);

        $sipRequest = new StoreEmployeeSipRequest([
            'sip'              => $request->input('sip'),
            'sms_kimlik'       => $smsKimlik->id,
            'not_send_message' => $request->input('not_send_message', NumericalConstant::ZERO)
        ]);

        (new SmsKimlikSipController)->store($sipRequest);

        return response()->json([
            'message' => 'Personel başarıyla oluşturuldu.',
            'data' => $smsKimlik
        ], Response::HTTP_CREATED);
    }

    /**
     * @param UpdateEmployeeRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws EmployeeNotFoundException
     * @throws EmployeeSipNotFoundException
     */
    public function update(UpdateEmployeeRequest $request, int $id): JsonResponse
    {
        $smsKimlik = SmsKimlik::findOrFail($id);
        if (empty($smsKimlik)) {
            return throw new EmployeeNotFoundException();
        }

        $smsKimlik = $smsKimlik->update([
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

        return response()->json([
            'message' => 'Personel başarıyla güncellendi.',
            'data' => $smsKimlik
        ], Response::HTTP_OK);
    }

    /**
     * @param ChangePasswordEmployeeRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws EmployeeNotFoundException
     */
    public function changePassword(ChangePasswordEmployeeRequest $request, int $id): JsonResponse
    {
        $smsKimlik = SmsKimlik::findOrFail($id);
        if (empty($smsKimlik)) {
            return throw new EmployeeNotFoundException();
        }

        $smsKimlik = $smsKimlik->update(['sifre' => $request->input('new_password')]);

        return response()->json([
            'message' => 'Personel şifresi başarıyla güncellendi.',
            'data' => $smsKimlik
        ], Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws EmployeeNotFoundException
     */
    public function destroy(int $id): JsonResponse
    {
        $smsKimlik = SmsKimlik::findOrFail($id);
        if (empty($smsKimlik)) {
            return throw new EmployeeNotFoundException();
        }

        $smsKimlik->durum = Status::PASSIVE;
        $smsKimlik->update();

        return response()->json('Personel başarıyla silindi.', Response::HTTP_OK);
    }
}
