<?php

namespace App\Http\Requests\Blocked;

use App\Http\Requests\AbstractRequest;

class IndexBlockedPhoneRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'phone'          => 'sometimes|string|max:15',
            'process_person' => 'sometimes|integer',
            'start_date'     => 'sometimes|string',
            'max_date'       => 'sometimes|string',
        ];
    }
}
