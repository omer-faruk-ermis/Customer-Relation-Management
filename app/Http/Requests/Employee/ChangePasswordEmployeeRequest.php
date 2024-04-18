<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\AbstractRequest;

class ChangePasswordEmployeeRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'new_password' => 'required|string',
        ];
    }
}
