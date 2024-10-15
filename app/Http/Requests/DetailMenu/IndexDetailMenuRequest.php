<?php

namespace App\Http\Requests\DetailMenu;

use App\Http\Requests\AbstractRequest;

class IndexDetailMenuRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['employee_id'];
    */

    public function rules(): array
    {
        return [
            'employee_id' => 'sometimes|integer',
        ];
    }
}
