<?php

namespace App\Http\Requests\Reason;

use App\Http\Requests\AbstractRequest;

class IndexReasonRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'type' => 'sometimes|string',
        ];
    }
}
