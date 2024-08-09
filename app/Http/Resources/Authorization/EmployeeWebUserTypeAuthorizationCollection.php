<?php

namespace App\Http\Resources\Authorization;

use App\Http\Resources\AbstractCollection;

/**
 * Class EmployeeWebUserTypeAuthorizationCollection
 *
 * @package App\Http\Resources\Authorization
 *
 * @mixin mixed
 */
class EmployeeWebUserTypeAuthorizationCollection extends AbstractCollection
{
    public $collects = EmployeeWebUserTypeAuthorizationResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
