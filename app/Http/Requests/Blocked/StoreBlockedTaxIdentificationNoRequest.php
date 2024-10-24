<?php

namespace App\Http\Requests\Blocked;

use App\Http\Requests\AbstractRequest;

class StoreBlockedTaxIdentificationNoRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'tax_identification_no' => 'required|digits:10',
            'description'           => 'sometimes|string',
        ];
    }
}
