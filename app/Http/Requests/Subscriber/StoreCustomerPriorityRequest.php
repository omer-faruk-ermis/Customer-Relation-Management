<?php

namespace App\Http\Requests\Subscriber;

use App\Enums\CustomerPriority;
use App\Http\Requests\AbstractRequest;

class StoreCustomerPriorityRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['web_user_id'];

    public function rules(): array
    {
        return [
            'type'        => 'required|integer|in:' . implode(',', [CustomerPriority::SPECIAL, CustomerPriority::VIP]),
            'sip'         => 'required|integer',
            'description' => 'sometimes|string',
            'web_user_id' => 'required|string'
        ];
    }
}
