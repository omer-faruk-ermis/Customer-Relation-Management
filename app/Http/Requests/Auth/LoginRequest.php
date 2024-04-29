<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractRequest;

class LoginRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'email'              => 'required|email',
            'password'           => 'required|string',
            'security_code'      => 'required|string',
            'security_code_path' => 'required|string',
        ];
    }
}
