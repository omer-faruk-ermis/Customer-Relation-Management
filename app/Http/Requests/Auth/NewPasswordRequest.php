<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractRequest;

class NewPasswordRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'code'               => 'required|string',
            'new_password'       => 'required|string',
            'new_password_again' => 'required|string',
        ];
    }
}
