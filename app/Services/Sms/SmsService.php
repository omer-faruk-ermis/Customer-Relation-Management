<?php

namespace App\Services\Sms;

use App\Enums\Code;
use App\Exceptions\Sms\OtpMessageNotSendException;
use App\Helpers\CacheClear;
use App\Helpers\SmsVerificationValidate;
use App\Helpers\TokenValidate;
use App\Http\Proxies\SmsProxy;
use App\Http\Requests\Sms\SmsVerificationRequest;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * Class SmsService
 *
 * @package App\Service\Sms
 */
class SmsService
{
    /**
     * @param Request  $request
     *
     * @return array
     * @throws Exception|GuzzleException
     */
    public function smsCode(Request $request): array
    {
        $token = $request->input('netgsmsessionid');
        TokenValidate::handle($token);

        if (Cache::has("verification_code_info_$token") &&
            ((Cache::get("verification_code_info_$token")['create_date'])->diffInSeconds(Carbon::now()) < Code::DEFAULT_CODE_REMAINING_TIME)) {
            $diff = (Cache::get("verification_code_info_$token")['create_date'])->diffInSeconds(Carbon::now());
            return ['remaining_otp_time' => (Code::DEFAULT_CODE_REMAINING_TIME - $diff)];
        }

        $xmlResult = SmsProxy::otpCodeSms($token);

        if (!empty($xmlResult)) {
            $xml = simplexml_load_string($xmlResult);

            if ($xml->main->jobID) {
                return ['remaining_otp_time' => Code::DEFAULT_CODE_REMAINING_TIME];
            }
        }
        CacheClear::verifierCodeClear($token);
        CacheClear::imageClear($token);

        throw new OtpMessageNotSendException();
    }

    /**
     * @param SmsVerificationRequest  $request
     *
     * @return void
     * @throws Exception
     */
    public static function smsVerification(SmsVerificationRequest $request): void
    {
        TokenValidate::handle($request->input('netgsmsessionid'));
        SmsVerificationValidate::handle($request);
    }
}
