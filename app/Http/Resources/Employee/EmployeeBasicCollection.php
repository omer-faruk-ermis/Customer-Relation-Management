<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\AbstractCollection;

/**
 * Class EmployeeBasicCollection
 *
 * @package App\Http\Resources\Employee
 *
 * @mixin mixed
 */
class EmployeeBasicCollection extends AbstractCollection
{
    public $collects = EmployeeBasicResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}

