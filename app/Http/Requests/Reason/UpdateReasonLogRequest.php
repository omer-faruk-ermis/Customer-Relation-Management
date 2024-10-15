<?php

namespace App\Http\Requests\Reason;

use App\Http\Requests\AbstractRequest;

class UpdateReasonLogRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['log_id', 'reason_id'];
    */

    public function rules(): array
    {
        return [
            'log_id'      => 'required|string',
            'reason_id'   => 'required|string',
            'description' => 'sometimes|string'
        ];
    }
}
