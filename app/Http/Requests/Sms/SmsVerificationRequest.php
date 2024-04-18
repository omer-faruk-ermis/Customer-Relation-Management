<?php

namespace App\Http\Requests\Sms;

use App\Http\Requests\AbstractRequest;

class SmsVerificationRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'code' => 'required|string',
        ];
    }
}
