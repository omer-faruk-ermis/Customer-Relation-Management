<?php

namespace App\Http\Resources\WebUser;

use App\Http\Resources\AbstractCollection;

/**
 * Class WebUserTypeCollection
 *
 * @package App\Http\Resources\WebUser
 *
 * @mixin mixed
 */
class WebUserTypeCollection extends AbstractCollection
{
    public $collects = WebUserTypeResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
