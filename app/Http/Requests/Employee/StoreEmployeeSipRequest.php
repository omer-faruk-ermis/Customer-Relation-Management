<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\AbstractRequest;

class StoreEmployeeSipRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'sip'              => 'sometimes|integer',
            'sms_kimlik'       => 'sometimes|integer',
            'not_send_message' => 'sometimes|boolean',
        ];
    }
}
