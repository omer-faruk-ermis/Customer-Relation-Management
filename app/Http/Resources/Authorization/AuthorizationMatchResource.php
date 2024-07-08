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
            'smsManagement'    => AuthorizationCollection::make($this->smsManagement),
            'blueScreen'       => AuthorizationCollection::make($this->blueScreen),
            'authorization'    => AuthorizationCollection::make($this->authorization),
            'subscriberBillet' => AuthorizationCollection::make($this->subscriberBillet),
        ];
    }
}
