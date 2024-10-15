<?php

namespace App\Http\Requests\Staff;

use App\Http\Requests\AbstractRequest;

class StoreStaffGroupRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'name'        => 'required|string',
            'description' => 'sometimes|string',
            'state'       => 'required|boolean'
        ];
    }
}
