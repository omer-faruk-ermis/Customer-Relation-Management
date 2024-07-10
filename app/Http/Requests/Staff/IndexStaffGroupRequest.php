<?php

namespace App\Http\Requests\Staff;

use App\Http\Requests\AbstractRequest;

class IndexStaffGroupRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['employee_id'];

    public function rules(): array
    {
        return [
            'employee_id' => 'sometimes|string',
        ];
    }
}
