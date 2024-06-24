<?php

namespace App\Services\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class ClientService
 *
 * @package App\Service\Http
 */
class ClientService
{
    /**
     * @param string $method
     * @param string $url
     * @param string $contentType
     * @param string|null $body
     * @return string
     * @throws GuzzleException
     */
    public static function handle(string $method, string $url, string $contentType, string $body = null): string
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
}
