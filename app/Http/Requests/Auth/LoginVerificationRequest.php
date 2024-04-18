<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractRequest;

class LoginVerificationRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [];
    }
}
