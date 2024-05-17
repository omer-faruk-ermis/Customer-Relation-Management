<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\AbstractRequest;
use App\Utils\Security;

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

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('unit_id')) {
            $this->merge([
                             'unit_id' => Security::decrypt($this->input('unit_id'))
                         ]);
        }
    }
}
