<?php

namespace App\Http\Requests\Blocked;

use App\Http\Requests\AbstractRequest;

class StoreBlockedIdentityNoRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'identity_no' => 'required|integer|digits:11',
            'description' => 'sometimes|string',
        ];
    }
}
