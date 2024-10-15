<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\AbstractRequest;
use App\Utils\Security;

class IndexEmployeeLogRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['agent'];
    */

    public function rules(): array
    {
        return [
            'web_user'          => 'sometimes|integer',
            'max_date'          => 'sometimes|date',
            'min_date'          => 'sometimes|date',
            'log_subject'       => 'sometimes|string',
            'page'              => 'sometimes|integer',
            'agent'             => 'required|integer',
            'description'       => 'sometimes|string',
            'reason'            => 'sometimes|string',
            'empty_reason'      => 'sometimes|boolean',
            'empty_description' => 'sometimes|boolean',
        ];
    }
}
