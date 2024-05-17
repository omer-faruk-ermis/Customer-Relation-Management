<?php

namespace App\Http\Requests\Staff;

use App\Http\Requests\AbstractRequest;

class UpdateStaffGroupRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'name'        => 'sometimes|string',
            'description' => 'sometimes|string',
            'state'       => 'sometimes|boolean',
        ];
    }
}
