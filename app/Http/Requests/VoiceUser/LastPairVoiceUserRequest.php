<?php

namespace App\Http\Requests\VoiceUser;

use App\Http\Requests\AbstractRequest;

class LastPairVoiceUserRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'call_phone'    => 'required|string',
        ];
    }
}
