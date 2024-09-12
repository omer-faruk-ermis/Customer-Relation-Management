<?php

namespace App\Http\Requests\Subject;

use App\Http\Requests\AbstractRequest;

class StoreSubjectInformationRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['parent_id', 'use_place_id', 'user_type_ids'];

    public function rules(): array
    {
        return [
            'name'          => 'required|string',
            'description'   => 'sometimes|string',
            'parent_id'     => 'required|string',
            'use_place_id'  => 'required|string',
            'user_type_ids' => 'sometimes|string',
        ];
    }
}
