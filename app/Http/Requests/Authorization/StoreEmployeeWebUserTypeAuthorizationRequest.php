<?php

namespace App\Http\Requests\Authorization;

use App\Http\Requests\AbstractRequest;

class StoreEmployeeWebUserTypeAuthorizationRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['employee_id'];
    */

    public function rules(): array
    {
        return [
            'employee_id'   => 'required|integer',
            'web_user_type' => 'required|integer',
            'operator_code' => 'required|integer',
        ];
    }
}
