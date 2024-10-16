<?php

namespace App\Http\Requests\DetailMenu;

use App\Http\Requests\AbstractRequest;

class StoreDetailMenuUserRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['authorization_id', 'employee_id'];
    */

    public function rules(): array
    {
        return [
            'authorization_id' => 'required|integer',
            'employee_id'      => 'required|integer',
        ];
    }
}
