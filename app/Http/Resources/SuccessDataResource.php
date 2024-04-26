<?php

namespace App\Http\Resources;

/**
 * Class SuccessDataResource
 *
 * This resource is used when the to be sent data wanted to be unchanged.
 *
 * @package App\Http\Resources
 */
final class SuccessDataResource extends AbstractResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => $this->resource
        ];
    }
}
