<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\AbstractRequest;

class UpdateEmployeeRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['unit_id'];

    public function rules(): array
    {
        return [
            'full_name'        => 'sometimes|string',
            'login_permission' => 'sometimes|boolean',
            'unit_id'          => 'sometimes|string',
            'currency_limit'   => 'sometimes|numeric',
            'mobile_phone'     => 'sometimes|integer',
            'email'            => 'sometimes|email',
            'username'         => 'sometimes|string',
            'email_password'   => 'sometimes|string',
            'home_phone'       => 'sometimes|integer',
        ];
    }
}
