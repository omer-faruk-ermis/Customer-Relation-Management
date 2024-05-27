<?php

namespace App\Http\Requests\Staff;

use App\Http\Requests\AbstractRequest;

class StoreStaffGroupMatchRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['staff_id', 'staff_group_id'];

    public function rules(): array
    {
        return [
            'staff_id'       => 'required|string',
            'staff_group_id' => 'required|string',
        ];
    }
}
