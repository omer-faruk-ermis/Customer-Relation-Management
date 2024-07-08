<?php

namespace App\Http\Resources\WebPortal;

use App\Http\Resources\AbstractCollection;

/**
 * Class WebPortalAuthorizationMenuCollection
 *
 * @package App\Http\Resources\WebPortal
 *
 * @mixin mixed
 */
class WebPortalAuthorizationMenuCollection extends AbstractCollection
{
    public $collects = WebPortalAuthorizationResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return (object) [
            'app' => $this->collection->first()->tanim,
            'menu' => $this
                ->collection
                ->groupBy('yetki_detay')
                ->map(function ($group, $key) {
                    return (object) [
                        'menu' => $key,
                        'pages' => $group
                    ];
                })
        ];
    }
}
