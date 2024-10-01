<?php

namespace App\Http\Requests\Reason;

use App\Http\Requests\AbstractRequest;

class StoreReasonRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['parent_id'];

    public function rules(): array
    {
        return [
            'description' => 'sometimes|string',
            'parent_id'   => 'sometimes|string',
        ];
    }
}
