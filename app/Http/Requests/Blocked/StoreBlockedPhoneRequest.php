<?php

namespace App\Http\Requests\Blocked;

use App\Http\Requests\AbstractRequest;

class StoreBlockedPhoneRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'phone'       => 'required|string|min:8|max:15',
            'description' => 'sometimes|string',
        ];
    }
}
