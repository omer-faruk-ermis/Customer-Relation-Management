<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * Abstract class AbstractCollection
 *
 * @package App\Http\Resources
 */
abstract class AbstractCollection extends ResourceCollection
{
    use ResourceableTrait;

    /**
     * AbstractCollection constructor.
     *
     * @param mixed        $resource
     * @param string|null  $message
     * @param int          $statusCode
     */
    public function __construct($resource, ?string $message = null, int $statusCode = Response::HTTP_OK)
    {
        parent::__construct($resource);

        $this->message = $message;
        $this->statusCode = $statusCode;
    }
}
