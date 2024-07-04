<?php

namespace App\Http\Resources\Authorization;

use App\Http\Resources\AbstractResource;

/**
 * Class AuthorizationMatchResource
 *
 * @package App\Http\Resources\Authorization
 *
 * @mixin mixed
 */
class AuthorizationMatchResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'smsManagement'    => AuthorizationResource::collection($this->smsManagement),
            'blueScreen'       => AuthorizationResource::collection($this->blueScreen),
            'authorization'    => AuthorizationResource::collection($this->authorization),
            'subscriberBillet' => AuthorizationResource::collection($this->subscriberBillet)
        ];
    }
}
