<?php

namespace App\Http\Resources\Reason;

use App\Http\Resources\AbstractCollection;

/**
 * Class ReasonCollection
 *
 * @package App\Http\Resources\Reason
 *
 * @mixin mixed
 */
class ReasonCollection extends AbstractCollection
{
    public $collects = ReasonResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
