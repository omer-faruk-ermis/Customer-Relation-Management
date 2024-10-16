<?php

namespace App\Http\Requests\VoiceUser;

use App\Http\Requests\AbstractRequest;

class StoreVoiceUserRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['call_id', 'user_id'];
    */

    public function rules(): array
    {
        return [
            'call_id' => 'required|integer',
            'user_id' => 'required|integer',
            'type'    => 'sometimes|integer',
        ];
    }
}
