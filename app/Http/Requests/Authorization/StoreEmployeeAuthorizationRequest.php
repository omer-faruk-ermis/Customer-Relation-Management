<?php

namespace App\Http\Requests\Authorization;

use App\Http\Requests\AbstractRequest;

class StoreEmployeeAuthorizationRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['employee_id', 'authorization_id'];
    */

    public function rules(): array
    {
        return [
            'employee_id'      => 'required|integer',
            'authorization_id' => 'required|integer',
        ];
    }
}
