<?php

namespace App\Http\Requests\Staff;

use App\Http\Requests\AbstractRequest;

class StoreStaffGroupAuthorizationMatchRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['staff_group_id', 'authorization_id'];

    public function rules(): array
    {
        return [
            'staff_group_id'   => 'required|string',
            'authorization_id' => 'required|string',
            'type'             => 'required|boolean'
        ];
    }
}
