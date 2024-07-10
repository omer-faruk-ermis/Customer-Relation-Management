<?php

namespace App\Http\Requests\Menu;

use App\Http\Requests\AbstractRequest;

class IndexMenuDefinitionRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['employee_id'];

    public function rules(): array
    {
        return [
            'employee_id' => 'sometimes|string',
        ];
    }
}
