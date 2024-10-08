<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\AbstractRequest;

class UpdateEmployeeRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['unit_id'];

    public function rules(): array
    {
        return [
            'full_name'        => ['sometimes', 'string', ...$this->getEncryptRules()],
            'login_permission' => 'required|boolean',
            'unit_id'          => 'sometimes|string',
            'currency_limit'   => 'sometimes|numeric',
            'mobile_phone'     => ['sometimes', 'string', ...$this->getEncryptRules()],
            'email'            => ['sometimes', 'string', ...$this->getEncryptRules()],
            'home_phone'       => ['sometimes', 'string', ...$this->getEncryptRules()],
        ];
    }
}
