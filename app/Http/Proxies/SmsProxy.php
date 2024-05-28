<?php

namespace App\Http\Proxies;

use App\Enums\ContentType;
use App\Enums\Http as HttpMethod;
use App\Enums\Url\ApiNetgsmUrl;
use App\Helpers\XmlGenerator;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SmsProxy
{
    /**
     * @param $fields
     * @return string
     */
    public static function sendHttpSms($fields): string
    {
        return self::http(HttpMethod::POST, ApiNetgsmUrl::getUrl(ApiNetgsmUrl::SEND_GET_SMS), ContentType::JSON, [
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
        return self::http(HttpMethod::POST, ApiNetgsmUrl::getUrl(ApiNetgsmUrl::SENDER_NAME), ContentType::JSON, $fields);
    }

    /**
     * @param string $token
     * @return string|null
     * @throws GuzzleException
     */
    public static function otpCodeSms(string $token): ?string
    {
        try {
            return self::client(HttpMethod::POST, ApiNetgsmUrl::getUrl(ApiNetgsmUrl::SEND_OTP_SMS), ContentType::XML, XmlGenerator::otpSms($token));
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
        return self::client(HttpMethod::POST, ApiNetgsmUrl::getUrl(ApiNetgsmUrl::SEND_XML_SMS), ContentType::XML, XmlGenerator::sms($token));
    }

    /**
     * @param string $method
     * @param string $url
     * @param string $contentType
     * @param string|null $body
     * @return string
     * @throws GuzzleException
     */
    private static function client(string $method = HttpMethod::GET, string $url = ApiNetgsmUrl::DEFAULT_SEND_GET_SMS, string $contentType = ContentType::XML, string $body = null): string
    {
        return
            (new Client())
                ->request($method, $url,
                    [
                        'headers' => [
                            'Content-Type' => $contentType,
                        ],
                        'body'    => $body,
                    ])
                ->getBody()
                ->getContents();
    }

    /**
     * @param string $method
     * @param string $url
     * @param string $contentType
     * @param array $body
     * @return string
     */
    private static function http(string $method = HttpMethod::GET, string $url = ApiNetgsmUrl::DEFAULT_SEND_GET_SMS, string $contentType = ContentType::JSON, array $body = []): string
    {
        $request = Http::withHeaders(['Content-Type' => $contentType]);

        return match ($method) {
            HttpMethod::POST => $request->post($url, $body)->body(),
            HttpMethod::PUT => $request->put($url, $body)->body(),
            HttpMethod::DELETE => $request->delete($url)->body(),
            default => $request->get($url)->body(),
        };
    }
}
