<?php

namespace App\Http\Requests\Url;

use App\Http\Requests\AbstractRequest;

class IndexUrlDefinitionRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['employee_id'];
    */

    public function rules(): array
    {
        return [
            'employee_id' => 'sometimes|string',
        ];
    }
}
