<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractRequest;

class ForgotPasswordRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'email'              => 'required|email',
            'security_code'      => 'required|string',
            'security_code_path' => 'required|string',
        ];
    }
}
