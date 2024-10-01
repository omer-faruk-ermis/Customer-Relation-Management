<?php

namespace App\Http\Requests\Reason;

use App\Http\Requests\AbstractRequest;

class IndexReasonRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['type'];

    public function rules(): array
    {
        return [
            'type' => 'sometimes|string',
        ];
    }
}
