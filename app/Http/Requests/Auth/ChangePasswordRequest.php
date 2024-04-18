<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractRequest;

class ChangePasswordRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'old_password'       => 'required|string',
            'new_password'       => 'required|string',
            'new_password_again' => 'required|string',
        ];
    }
}
