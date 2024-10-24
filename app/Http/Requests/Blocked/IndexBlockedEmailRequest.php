<?php

namespace App\Http\Requests\Blocked;

use App\Http\Requests\AbstractRequest;

class IndexBlockedEmailRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'email'          => 'sometimes|email|max:255',
            'process_person' => 'sometimes|integer',
            'start_date'     => 'sometimes|string',
            'max_date'       => 'sometimes|string',
        ];
    }
}
