<?php

namespace App\Http\Requests\Blocked;

use App\Http\Requests\AbstractRequest;

class StoreBlockedEmailRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'email'       => 'required|email|max:255',
            'description' => 'sometimes|string',
        ];
    }
}
