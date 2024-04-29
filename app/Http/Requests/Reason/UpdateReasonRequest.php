<?php

namespace App\Http\Requests\Reason;

use App\Http\Requests\AbstractRequest;

class UpdateReasonRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'log_id'      => 'required|integer',
            'reason_id'   => 'required|integer',
            'description' => 'sometimes|string'
        ];
    }
}
