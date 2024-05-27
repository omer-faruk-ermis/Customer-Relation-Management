<?php

namespace App\Http\Requests\Authorization;

use App\Http\Requests\AbstractRequest;

class StoreEmployeeAuthorizationRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['employee_id', 'url_id'];

    public function rules(): array
    {
        return [
            'employee_id' => 'sometimes|string',
            'url_id'      => 'required|string',
        ];
    }
}
