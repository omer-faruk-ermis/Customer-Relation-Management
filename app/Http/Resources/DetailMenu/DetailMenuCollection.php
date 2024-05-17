<?php

namespace App\Http\Resources\DetailMenu;

use App\Http\Resources\AbstractCollection;

/**
 * Class DetailMenuCollection
 *
 * @package App\Http\Resources\DetailMenu
 *
 * @mixin mixed
 */
class DetailMenuCollection extends AbstractCollection
{
    public $collects = DetailMenuResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
