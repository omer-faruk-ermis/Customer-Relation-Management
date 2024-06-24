<?php

namespace App\Http\Proxies;

use App\Enums\ContentType;
use App\Enums\Http as HttpMethod;
use App\Enums\Url\ApiNetgsmUrl;
use App\Helpers\XmlGenerator;
use App\Services\Http\ClientService;
use App\Services\Http\HttpService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class SmsProxy
{
    /**
     * @param $fields
     * @return string
     */
    public static function sendHttpSms($fields): string
    {
        return HttpService::handle(HttpMethod::POST, ApiNetgsmUrl::getUrl(ApiNetgsmUrl::SEND_GET_SMS), ContentType::JSON, [
            'usercode'  => config('git.user_code'),
            'password'  => config('git.password'),
            'gsmno'     => config('git.gsm'),
            'message'   => $fields['message'],
            'msgheader' => config('git.header'),
            'filter'    => config('git.filter'),
            'startdate' => $fields['start_date'],
            'stopdate'  => $fields['stop_date'],
            'appkey'    => config('git.app_key')
        ]);
    }

    /**
     * @param $fields
     * @return string
     */
    public function getSenderNames($fields): string
    {
        return HttpService::handle(HttpMethod::POST, ApiNetgsmUrl::getUrl(ApiNetgsmUrl::SENDER_NAME), ContentType::JSON, $fields);
    }

    /**
     * @param string  $token
     *
     * @return string|null
     * @throws Exception|GuzzleException
     */
    public static function otpCodeSms(string $token): ?string
    {
        try {
            return ClientService::handle(HttpMethod::POST, ApiNetgsmUrl::getUrl(ApiNetgsmUrl::SEND_OTP_SMS), ContentType::XML, XmlGenerator::otpSms($token));
        } catch (Exception $e) {
            Cache::forget("verification_code_info_$token");
            throw $e;
        }
    }

    /**
     * @param string $token
     * @return string
     * @throws GuzzleException
     */
    public static function sendXmlSms(string $token): string
    {
        return ClientService::handle(HttpMethod::POST, ApiNetgsmUrl::getUrl(ApiNetgsmUrl::SEND_XML_SMS), ContentType::XML, XmlGenerator::sms($token));
    }
}
