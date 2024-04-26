<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\AbstractResource;

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
            'id'               => $this->getKey(),
            'sip_id'           => $this->sip_id,
            'employee_id'      => $this->sms_kimlik,
            'not_send_message' => $this->mesajgitmesin,
        ];
    }
}
