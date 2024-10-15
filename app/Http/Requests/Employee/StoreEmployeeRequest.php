<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\AbstractRequest;

class StoreEmployeeRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['unit_id'];
    */

    public function rules(): array
    {
        $storeEmployeeSipRules = (new StoreEmployeeSipRequest())->rules();

        return array_merge([
                               'full_name'        => 'required|string|min:3|max:255',
                               'password'         => 'required|string|min:6|max:255',
                               'login_permission' => 'required|boolean',
                               'unit_id'          => 'required|integer|max:255',
                               'currency_limit'   => 'required|numeric',
                               'mobile_phone'     => 'required|integer',
                               'email'            => 'required|email|max:255',
                               'home_phone'       => 'sometimes|integer',
                           ],
                           $storeEmployeeSipRules);
    }
}
