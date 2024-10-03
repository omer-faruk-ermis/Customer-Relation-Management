<?php

namespace App\Http\Requests\Subscriber;

use App\Enums\CustomerPriority;
use App\Http\Requests\AbstractRequest;

class IndexCustomerPriorityRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'type'          => 'sometimes|integer|in:' . implode(',', [CustomerPriority::SPECIAL, CustomerPriority::VIP]),
            'sip'           => 'sometimes|integer',
            'description'   => 'sometimes|string',
            'web_user_id'   => 'sometimes|string',
            'subscriber_no' => 'sometimes|integer',
            'phone'         => 'sometimes|integer',
        ];
    }
}
