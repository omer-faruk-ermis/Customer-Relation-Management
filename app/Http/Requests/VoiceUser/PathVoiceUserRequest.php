<?php

namespace App\Http\Requests\VoiceUser;

use App\Http\Requests\AbstractRequest;

class PathVoiceUserRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'voice_record'    => 'required|string',
            'call_start_date' => 'required|string'
        ];
    }
}
