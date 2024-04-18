<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractRequest;

class LoginRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'sms_kimlik_email'   => 'required|email',
            'sifre'              => 'required|string',
            'security_code'      => 'required|string',
            'security_code_path' => 'required|string',
        ];
    }
}
