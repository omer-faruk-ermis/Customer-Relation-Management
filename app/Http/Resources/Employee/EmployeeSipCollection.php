<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\AbstractCollection;

/**
 * Class EmployeeSipCollection
 *
 * @package App\Http\Resources\Employee
 *
 * @mixin mixed
 */
class EmployeeSipCollection extends AbstractCollection
{
    public $collects = EmployeeSipResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}

