<?php

namespace App\Http\Requests\WebPortal;

use App\Http\Requests\AbstractRequest;

class IndexWebPortalAuthorizationRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['employee_id'];
    */

    public function rules(): array
    {
        return [
            'employee_id' => 'sometimes|string',
        ];
    }
}
