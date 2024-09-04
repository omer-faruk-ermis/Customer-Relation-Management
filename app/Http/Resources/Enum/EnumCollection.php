<?php

namespace App\Http\Resources\Enum;

use App\Http\Resources\AbstractCollection;

/**
 * Class EnumCollection
 *
 * @package App\Http\Resources\Enum
 *
 * @mixin mixed
 */
class EnumCollection extends AbstractCollection
{
    public $collects = EnumResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
