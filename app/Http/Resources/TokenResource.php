<?php

namespace App\Http\Resources;

/**
 * Class TokenResource
 *
 * @package App\Http\Resources
 *
 * @mixin mixed
 */
class TokenResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'token'  => $this->token,
        ];
    }
}
