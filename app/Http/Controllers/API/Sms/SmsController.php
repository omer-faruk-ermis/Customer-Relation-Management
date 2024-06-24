<?php

namespace App\Http\Controllers\API\Sms;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sms\SmsVerificationRequest;
use App\Http\Resources\Sms\SmsCodeResource;
use App\Http\Resources\SuccessResource;
use App\Services\Sms\SmsService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    /** @var SmsService $smsService */
    private SmsService $smsService;

    /**
     * SmsController constructor
     */
    public function __construct()
    {
        $this->smsService = new SmsService();
    }

    /**
     * @param Request  $request
     *
     * @return SmsCodeResource
     * @throws Exception|GuzzleException
     */
    public function smsCode(Request $request): SmsCodeResource
    {
        $codeRemainingTime = $this->smsService->smsCode($request);

        return new SmsCodeResource($codeRemainingTime, 'SMS.CODE_SEND.SUCCESS');
    }

    /**
     * @param SmsVerificationRequest  $request
     *
     * @return SuccessResource
     * @throws Exception
     */
    public function smsVerification(SmsVerificationRequest $request): SuccessResource
    {
        $this->smsService->smsVerification($request);

        return new SuccessResource('SMS.CODE_VERIFICATION.SUCCESS');
    }
}
