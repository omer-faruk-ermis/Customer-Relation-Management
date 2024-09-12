<?php

namespace App\Http\Resources;

use App\Models\Log\KibanaLog;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trait ResourceTrait
 *
 * @package App\Http\Resources
 *
 */
trait ResourceableTrait
{
    /** @var string|null */
    protected ?string $message;

    /** @var int */
    protected int $statusCode = Response::HTTP_OK;

    /**
     * @param $request
     *
     * @return array
     */
    public function with($request): array
    {
        self::writeLogResourceMessage();
        return [
            'message' => $this->message,
            'success' => true
        ];
    }

    /**
     * @param $request
     * @param $response
     *
     * @return void
     */
    public function withResponse($request, $response): void
    {
        $response->setStatusCode($this->statusCode ?? Response::HTTP_OK);

        $response->withHeaders(Config::get('system.http.response.headers'));

        $request->header('Accept', Config::get('system.http.request.headers.Accept'));
    }

    /**
     * @return void
     */
    private function writeLogResourceMessage(): void
    {
        app()->instance('currentResourceMessage', $this->message);
        app()->instance('currentResourceStatusCode', $this->statusCode);
        (new KibanaLog())->send();
    }
}
