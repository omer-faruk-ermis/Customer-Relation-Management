<?php

namespace App\Http\Resources\WebPortal;

use App\Http\Resources\AbstractCollection;

/**
 * Class WebPortalAuthorizationPageCollection
 *
 * @package App\Http\Resources\WebPortal
 *
 * @mixin mixed
 */
class WebPortalAuthorizationPageCollection extends AbstractCollection
{
    public $collects = WebPortalAuthorizationResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
