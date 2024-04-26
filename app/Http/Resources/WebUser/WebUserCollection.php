<?php

namespace App\Http\Resources\WebUser;

use App\Http\Resources\AbstractCollection;

/**
 * Class WebUserCollection
 *
 * @package App\Http\Resources\WebUser
 *
 * @mixin mixed
 */
class WebUserCollection extends AbstractCollection
{
    public $collects = WebUserResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
