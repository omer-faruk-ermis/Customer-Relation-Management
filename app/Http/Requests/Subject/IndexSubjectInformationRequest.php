<?php

namespace App\Http\Requests\Subject;

use App\Http\Requests\AbstractRequest;

class IndexSubjectInformationRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['use_place_id'];
    */

    public function rules(): array
    {
        return [
            'use_place_id' => 'required|string',
        ];
    }
}
