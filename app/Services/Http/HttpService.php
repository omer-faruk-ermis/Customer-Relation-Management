<?php

namespace App\Services\Http;

use App\Enums\Http as HttpMethod;
use Illuminate\Support\Facades\Http;

/**
 * Class HttpService
 *
 * @package App\Service\Http
 */
class HttpService
{
    /**
     * @param string  $method
     * @param string  $url
     * @param string  $contentType
     * @param array   $body
     *
     * @return string
     */
    public static function handle(string $method, string $url, string $contentType, array $body = []): string
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
