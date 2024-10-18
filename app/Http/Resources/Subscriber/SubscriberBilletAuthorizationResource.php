<?php

namespace App\Http\Resources\Subscriber;

use App\Http\Resources\AbstractResource;

/**
 * Class SubscriberBilletAuthorizationResource
 *
 * @package App\Http\Resources\Subscriber
 *
 * @mixin mixed
 */
class SubscriberBilletAuthorizationResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'          => $this->getKey(),
            'description' => $this->aciklama,
            'state'       => $this->durum,
            'menu'        => $this->menu,
        ];
    }
}
