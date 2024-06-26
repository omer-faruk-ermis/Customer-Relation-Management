<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\AbstractRequest;

class StoreEmployeeRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['unit_id'];

    public function rules(): array
    {
        $storeEmployeeSipRules = (new StoreEmployeeSipRequest())->rules();

        return array_merge([
                               'full_name'        => 'required|string',
                               'password'         => 'required|string',
                               'login_permission' => 'required|boolean',
                               'unit_id'          => 'required|string',
                               'currency_limit'   => 'required|numeric',
                               'mobile_phone'     => 'required|integer',
                               'email'            => 'required|email',
                               'username'         => 'sometimes|string',
                               'email_password'   => 'sometimes|string',
                               'home_phone'       => 'sometimes|integer',
                           ],
                           $storeEmployeeSipRules);
    }
}
