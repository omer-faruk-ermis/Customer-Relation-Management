<?php

namespace App\Http\Requests\Blocked;

use App\Http\Requests\AbstractRequest;

class IndexBlockedIdentityNoRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'identity_no'    => 'sometimes|integer|digits_between:0,11',
            'process_person' => 'sometimes|integer',
            'start_date'     => 'sometimes|string',
            'max_date'       => 'sometimes|string',
        ];
    }
}
