<?php

namespace App\Http\Controllers\API\Sms;

use App\Helpers\SmsVerificationValidate;
use App\Helpers\TokenValidate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sms\SmsVerificationRequest;
use Exception;

class SmsController extends Controller
{
    /**
     * @throws Exception
     */
    public static function smsVerification(SmsVerificationRequest $request)
    {
        TokenValidate::handle($request->input('netgsmsessionid'));
        SmsVerificationValidate::handle($request);

        return response()->json(['success' => true,
                                 'message' => 'Sms onayı başarılı, oturumunuz açılıyor.']);
    }
}
