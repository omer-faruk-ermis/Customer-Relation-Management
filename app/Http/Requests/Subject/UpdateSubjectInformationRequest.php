<?php

namespace App\Http\Requests\Subject;

use App\Http\Requests\AbstractRequest;

class UpdateSubjectInformationRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['use_place_id'];
    */

    public function rules(): array
    {
        return [
            'name'          => 'sometimes|string',
            'description'   => 'sometimes|string',
            'use_place_id'  => 'sometimes|string',
            'use_state'     => 'sometimes|integer',
            'user_type_ids' => 'sometimes|string',
        ];
    }
}
