<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\AbstractRequest;

class StoreEmployeeSipRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['employee_id'];

    public function rules(): array
    {
        return [
            'sip'              => 'sometimes|integer',
            'employee_id'      => 'sometimes|string',
            'not_send_message' => 'sometimes|boolean',
        ];
    }
}
