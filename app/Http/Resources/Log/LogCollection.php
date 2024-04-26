<?php

namespace App\Http\Resources\Log;

use App\Http\Resources\AbstractCollection;

/**
 * Class LogCollection
 *
 * @package App\Http\Resources\Log
 *
 * @mixin mixed
 */
class LogCollection extends AbstractCollection
{
    public $collects = LogResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
