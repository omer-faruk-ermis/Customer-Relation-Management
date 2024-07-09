<?php

namespace App\Http\Requests\DetailMenu;

use App\Http\Requests\AbstractRequest;

class StoreDetailMenuUserRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['menu_id', 'employee_id'];

    public function rules(): array
    {
        return [
            'menu_id'     => 'required|string',
            'employee_id' => 'required|string',
        ];
    }
}
