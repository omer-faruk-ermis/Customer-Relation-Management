<?php

namespace App\Http\Resources\Reason;

use App\Http\Resources\AbstractCollection;

/**
 * Class ReasonWantedCollection
 *
 * @package App\Http\Resources\Reason
 *
 * @mixin mixed
 */
class ReasonWantedCollection extends AbstractCollection
{
    public $collects = ReasonWantedResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
