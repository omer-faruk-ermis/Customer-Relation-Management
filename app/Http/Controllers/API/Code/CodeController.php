<?php

namespace App\Http\Controllers\API\Code;

use App\Enums\Code;
use App\Exceptions\Sms\OtpMessageNotSendException;
use App\Helpers\CacheClear;
use App\Helpers\CodeGenerator;
use App\Helpers\TokenValidate;
use App\Http\Controllers\Controller;
use App\Http\Proxies\SmsProxy;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CodeController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function securityCode(): JsonResponse
    {
        $image_path = CodeGenerator::generateSecurityCodeImage();
        $image = Storage::get('public/' . $image_path);

        return response()->json([
            'image_path'    => $image_path,
            'image_content' => base64_encode($image),
            'content_type'  => 'image/png'
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws GuzzleException
     * @throws Exception
     */
    public function smsCode(Request $request): JsonResponse
    {
        $token = $request->input('netgsmsessionid');
        TokenValidate::handle($token);

        if (Cache::has("verification_code_info_$token") &&
            ((Cache::get("verification_code_info_$token")['create_date'])->diffInSeconds(Carbon::now()) < Code::DEFAULT_CODE_REMAINING_TIME)) {
            $diff = (Cache::get("verification_code_info_$token")['create_date'])->diffInSeconds(Carbon::now());
            return response()->json(['success' => ['remaining_otp_time' => (Code::DEFAULT_CODE_REMAINING_TIME - $diff)]]);
        }

        $xmlResult = SmsProxy::otpCodeSms($token);

        if (!empty($xmlResult)) {
            $xml = simplexml_load_string($xmlResult);

            if ($xml->main->jobID) {
                return response()->json(['success' => ['remaining_otp_time' => (Code::DEFAULT_CODE_REMAINING_TIME)]]);
            }
        }
        CacheClear::verifierCodeClear($token);
        CacheClear::imageClear($token);

        throw new OtpMessageNotSendException();
    }
}
