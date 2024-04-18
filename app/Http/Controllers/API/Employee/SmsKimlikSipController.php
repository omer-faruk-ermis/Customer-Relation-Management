<?php

namespace App\Http\Controllers\API\Employee;

use App\Enums\NumericalConstant;
use App\Exceptions\Employee\EmployeeSipNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\IndexEmployeeSipRequest;
use App\Http\Requests\Employee\StoreEmployeeSipRequest;
use App\Models\SmsKimlik\SmsKimlikSip;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SmsKimlikSipController extends Controller
{
    /**
     * @param IndexEmployeeSipRequest $request
     * @return JsonResponse
     */
    public function index(IndexEmployeeSipRequest $request): JsonResponse
    {
        return response()->json([
            'message' => true,
            'data'    => SmsKimlikSip::get()
        ], Response::HTTP_OK);
    }

    /**
     * @param StoreEmployeeSipRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(StoreEmployeeSipRequest $request): JsonResponse
    {
        $smsKimlikSip = SmsKimlikSip::create([
            'sms_kimlik'    => $request->input('sms_kimlik'),
            'sip_id'        => $request->input('sip'),
            'mesajgitmesin' => $request->input('not_send_message', NumericalConstant::ZERO),
        ]);

        return response()->json([
            'message' => 'Personel dahili numarası başarıyla oluşturuldu.',
            'data'    => $smsKimlikSip
        ], Response::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws EmployeeSipNotFoundException
     */
    public function destroy(int $id): JsonResponse
    {
        $smsKimlikSip = SmsKimlikSip::findOrFail($id);
        if (empty($smsKimlikSip)) {
            return throw new EmployeeSipNotFoundException();
        }

        $smsKimlikSip->delete();

        return response()->json('Personel dahili numarası başarıyla silindi.', Response::HTTP_OK);
    }
}
