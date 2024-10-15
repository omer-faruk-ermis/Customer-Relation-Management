<?php

namespace App\Http\Requests\Subscriber;

use App\Enums\CustomerPriority;
use App\Http\Requests\AbstractRequest;

class UpdateCustomerPriorityRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['web_user_id'];
    */

    public function rules(): array
    {
        return [
            'type'        => 'required|integer|in:' . CustomerPriority::SPECIAL,
            'sip'         => 'sometimes|integer',
            'description' => 'sometimes|string',
            'web_user_id' => 'required|integer'
        ];
    }
}
