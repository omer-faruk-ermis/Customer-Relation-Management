<?php

namespace App\Http\Resources;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class SuccessResource
 *
 * This resource is used when there is no data to be sent.
 *
 * @package App\Http\Resources
 */
final class SuccessResource extends AbstractResource
{
    /**
     * SuccessResource constructor.
     *
     * @param string|null $message
     * @param int         $statusCode
     */
    public function __construct(?string $message = null, int $statusCode = Response::HTTP_OK)
    {
        parent::__construct(null, $message, $statusCode);
    }

    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [];
    }
}
