<?php

namespace App\Http\Requests\Staff;

use App\Http\Requests\AbstractRequest;

class StoreStaffGroupRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['recorder_id'];

    public function rules(): array
    {
        return [
            'name'        => 'required|string',
            'description' => 'sometimes|string',
            'state'       => 'required|boolean'
        ];
    }
}
