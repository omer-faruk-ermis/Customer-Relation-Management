<?php

namespace App\Http\Resources\Subscriber;

use App\Http\Resources\AbstractCollection;

/**
 * Class SubscriberBilletAuthorizationCollection
 *
 * @package App\Http\Resources\Subscriber
 *
 * @mixin mixed
 */
class SubscriberBilletAuthorizationCollection extends AbstractCollection
{
    public $collects = SubscriberBilletAuthorizationResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
