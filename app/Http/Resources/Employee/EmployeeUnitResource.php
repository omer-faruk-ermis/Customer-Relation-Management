<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\AbstractResource;
use App\Utils\Security;

/**
 * Class EmployeeUnitResource
 *
 * @package App\Http\Resources\Employee
 *
 * @mixin mixed
 */
class EmployeeUnitResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'   => $this->getKey(),
            'unit' => $this->birim
        ];
    }
}
