<?php

namespace App\Http\Resources\Subscriber;

use App\Http\Resources\AbstractResource;

/**
 * Class SubscriberBilletMenuAuthorizationResource
 *
 * @package App\Http\Resources\Subscriber
 *
 * @mixin mixed
 */
class SubscriberBilletMenuAuthorizationResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'name'  => $this->name,
            'pages' => SubscriberBilletAuthorizationResource::collection($this->pages),
        ];
    }
}
