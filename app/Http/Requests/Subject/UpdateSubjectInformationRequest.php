<?php

namespace App\Http\Requests\Subject;

use App\Http\Requests\AbstractRequest;

class UpdateSubjectInformationRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['use_place_id', 'user_type_ids'];

    public function rules(): array
    {
        return [
            'name'          => 'sometimes|string',
            'description'   => 'sometimes|string',
            'use_place_id'  => 'sometimes|string',
            'user_type_ids' => 'sometimes|string',
        ];
    }
}
