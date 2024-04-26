<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\AbstractCollection;

/**
 * Class EmployeeCollection
 *
 * @package App\Http\Resources\Employee
 *
 * @mixin mixed
 */
class EmployeeCollection extends AbstractCollection
{
    public $collects = EmployeeResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}

