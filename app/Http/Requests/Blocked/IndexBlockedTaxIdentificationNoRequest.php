<?php

namespace App\Http\Requests\Blocked;

use App\Http\Requests\AbstractRequest;

class IndexBlockedTaxIdentificationNoRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'tax_identification_no' => 'sometimes|integer|digits_between:0,10',
            'process_person'        => 'sometimes|integer',
            'start_date'            => 'sometimes|string',
            'max_date'              => 'sometimes|string',
        ];
    }
}
