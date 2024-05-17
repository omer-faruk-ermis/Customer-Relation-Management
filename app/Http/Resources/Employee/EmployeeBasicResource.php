<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\AbstractResource;
use App\Utils\Security;

/**
 * Class EmployeeBasicResource
 *
 * @package App\Http\Resources\Employee
 *
 * @mixin mixed
 */
class EmployeeBasicResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                    => Security::encrypt($this->getKey()),
            'full_name'             => $this->ad_soyad
        ];
    }
}
