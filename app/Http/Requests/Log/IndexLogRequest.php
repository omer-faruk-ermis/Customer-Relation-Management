<?php

namespace App\Http\Requests\Log;

use App\Http\Requests\AbstractRequest;

class IndexLogRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['process_person', 'agent'];

    public function rules(): array
    {
        return [
            'web_user'          => 'sometimes|integer',
            'max_date'          => 'sometimes|date',
            'min_date'          => 'sometimes|date',
            'process_person'    => 'sometimes|string',
            'log_subject'       => 'sometimes|string',
            'page'              => 'sometimes|integer',
            'agent'             => 'sometimes|string',
            'description'       => 'sometimes|string',
            'reason'            => 'sometimes|string',
            'empty_reason'      => 'sometimes|boolean',
            'empty_description' => 'sometimes|boolean',
        ];
    }
}
