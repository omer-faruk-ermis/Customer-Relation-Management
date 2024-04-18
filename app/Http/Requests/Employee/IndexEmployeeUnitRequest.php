<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\AbstractRequest;

class IndexEmployeeUnitRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'id' => 'sometimes|integer',
        ];
    }
}
