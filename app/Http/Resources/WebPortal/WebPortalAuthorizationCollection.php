<?php

namespace App\Http\Resources\WebPortal;

use App\Http\Resources\AbstractCollection;

/**
 * Class WebPortalAuthorizationCollection
 *
 * @package App\Http\Resources\WebPortal
 *
 * @mixin mixed
 */
class WebPortalAuthorizationCollection extends AbstractCollection
{
    public $collects = WebPortalAuthorizationResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return
            $this
                ->collection
                ->map(function ($item) {
                    return new WebPortalAuthorizationResource($item);
                })
                ->groupBy('tanim');
    }
}
