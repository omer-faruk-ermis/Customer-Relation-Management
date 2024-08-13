<?php

namespace App\Http\Requests\Authorization;

use App\Http\Requests\AbstractRequest;

class CopyAuthorizationRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['employee_id', 'receiver_id'];

    public function rules(): array
    {
        return [
            'employee_id' => 'required|string',
            'receiver_id' => 'required|integer',
        ];
    }
}
