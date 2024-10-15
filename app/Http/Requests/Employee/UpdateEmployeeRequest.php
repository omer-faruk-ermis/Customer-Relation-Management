<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\AbstractRequest;

class UpdateEmployeeRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['unit_id'];
    */

    public function rules(): array
    {
        return [
            'full_name'        => 'sometimes|string',
            'login_permission' => 'required|boolean',
            'unit_id'          => 'sometimes|integer',
            'currency_limit'   => 'sometimes|numeric',
            'mobile_phone'     => 'sometimes|string',
            'email'            => 'sometimes|string',
            'home_phone'       => 'sometimes|string',
        ];
    }
}
