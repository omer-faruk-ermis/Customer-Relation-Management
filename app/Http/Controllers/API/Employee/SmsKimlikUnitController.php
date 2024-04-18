<?php

namespace App\Http\Controllers\API\Employee;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\IndexEmployeeUnitRequest;
use App\Models\SmsKimlik\SmsKimlikBirim;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SmsKimlikUnitController extends Controller
{
    /**
     * @param IndexEmployeeUnitRequest $request
     * @return JsonResponse
     */
    public function index(IndexEmployeeUnitRequest $request): JsonResponse
    {
        return response()->json([
            'message' => true,
            'data'    => SmsKimlikBirim::get()->where('durum', '=', Status::ACTIVE)
        ], Response::HTTP_OK);
    }
}
