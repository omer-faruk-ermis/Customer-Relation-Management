<?php

namespace App\Http\Resources\Url;

use App\Http\Resources\AbstractCollection;

/**
 * Class UrlDefinitionCollection
 *
 * @package App\Http\Resources\Url
 *
 * @mixin mixed
 */
class UrlDefinitionCollection extends AbstractCollection
{
    public $collects = UrlDefinitionResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
