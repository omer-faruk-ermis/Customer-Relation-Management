<?php

namespace App\Http\Resources\Module;

use App\Http\Resources\AbstractCollection;

/**
 * Class ModuleCollection
 *
 * @package App\Http\Resources\Module
 *
 * @mixin mixed
 */
class ModuleCollection extends AbstractCollection
{
    public $collects = ModuleResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
