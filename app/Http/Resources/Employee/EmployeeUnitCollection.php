<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\AbstractCollection;

/**
 * Class EmployeeUnitCollection
 *
 * @package App\Http\Resources\Employee
 *
 * @mixin mixed
 */
class EmployeeUnitCollection extends AbstractCollection
{
    public $collects = EmployeeUnitResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}

