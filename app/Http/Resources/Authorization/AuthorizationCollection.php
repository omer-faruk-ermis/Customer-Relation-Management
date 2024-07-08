<?php

namespace App\Http\Resources\Authorization;

use App\Http\Resources\AbstractCollection;

/**
 * Class AuthorizationCollection
 *
 * @package App\Http\Resources\Authorization
 *
 * @mixin mixed
 */
class AuthorizationCollection extends AbstractCollection
{
    public $collects = AuthorizationResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return
            $this
                ->collection
                ->groupBy('menu');
    }
}
