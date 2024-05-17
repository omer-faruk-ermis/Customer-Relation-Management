<?php

namespace App\Http\Resources\Menu;

use App\Http\Resources\AbstractCollection;

/**
 * Class MenuDefinitionCollection
 *
 * @package App\Http\Resources\Menu
 *
 * @mixin mixed
 */
class MenuDefinitionCollection extends AbstractCollection
{
    public $collects = MenuDefinitionResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
