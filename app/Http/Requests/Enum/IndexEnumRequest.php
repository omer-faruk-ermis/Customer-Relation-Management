<?php

namespace App\Http\Requests\Enum;

use App\Http\Requests\AbstractRequest;

class IndexEnumRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'enum_type' => 'required|string'
        ];
    }
}
