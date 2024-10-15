<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\AbstractRequest;

class IndexEmployeeRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['sip', 'unit'];
    */

    public function rules(): array
    {
        return [
            'full_name'        => 'sometimes|string',
            'login_permission' => 'sometimes|boolean',
            'unit'             => 'sometimes|integer',
            'sip'              => 'sometimes|integer',
            'currency_limit'   => 'sometimes|numeric',
            'mobile_phone'     => 'sometimes|integer',
            'email'            => 'sometimes|email',
            'home_phone'       => 'sometimes|integer',
        ];
    }
}
