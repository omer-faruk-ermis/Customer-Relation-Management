<?php

namespace App\Http\Requests\Authorization;

use App\Http\Requests\AbstractRequest;

class IndexEmployeeWebUserTypeAuthorizationRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['employee_id'];
    */

    public function rules(): array
    {
        return [
            'employee_id' => 'required|string',
        ];
    }
}
