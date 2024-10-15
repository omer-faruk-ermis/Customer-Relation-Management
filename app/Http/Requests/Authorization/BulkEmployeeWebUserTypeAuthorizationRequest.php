<?php

namespace App\Http\Requests\Authorization;

use App\Http\Requests\AbstractRequest;

class BulkEmployeeWebUserTypeAuthorizationRequest extends AbstractRequest
{
    /*
     * protected $fieldsToDecrypt = [
        'bulk_authorizations' => [
            'employee_id'
        ]
    ];
    */

    public function rules(): array
    {
        return [
            'bulk_authorizations'                 => 'required|array',
            'bulk_authorizations.*.employee_id'   => 'required|string',
            'bulk_authorizations.*.web_user_type' => 'required|integer',
            'bulk_authorizations.*.operator_code' => 'required|integer',
            'bulk_authorizations.*.is_authorized' => 'required|boolean'
        ];
    }
}
