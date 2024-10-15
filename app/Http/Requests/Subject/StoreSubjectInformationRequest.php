<?php

namespace App\Http\Requests\Subject;

use App\Http\Requests\AbstractRequest;

class StoreSubjectInformationRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['parent_id', 'use_place_id'];
    */

    public function rules(): array
    {
        return [
            'name'          => 'required|string',
            'description'   => 'sometimes|string',
            'parent_id'     => 'required|integer',
            'use_place_id'  => 'required|integer',
            'user_type_ids' => 'sometimes|string',
        ];
    }
}
