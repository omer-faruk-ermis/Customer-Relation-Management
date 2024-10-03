<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\AbstractResource;
use App\Utils\Security;

/**
 * Class EmployeeSipResource
 *
 * @package App\Http\Resources\Employee
 *
 * @mixin mixed
 */
class EmployeeSipResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'               => Security::encrypt($this->getKey()),
            'sip'              => $this->sip_id,
            'employee_id'      => Security::encrypt($this->sms_kimlik),
            'not_send_message' => $this->mesajgitmesin,
            'employee'         => EmployeeResource::make($this->whenLoaded('employee')),
        ];
    }
}
