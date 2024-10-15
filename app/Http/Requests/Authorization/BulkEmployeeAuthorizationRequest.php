<?php

namespace App\Http\Requests\Authorization;

use App\Http\Requests\AbstractRequest;

class BulkEmployeeAuthorizationRequest extends AbstractRequest
{
    /*
     * protected $fieldsToDecrypt = [
        'bulk_authorizations' => [
            'employee_id',
            'authorization_id'
        ]
    ];
    */

    public function rules(): array
    {
        return [
            'bulk_authorizations'                    => 'required|array',
            'bulk_authorizations.*.employee_id'      => 'required|string',
            'bulk_authorizations.*.authorization_id' => 'required|string',
            'bulk_authorizations.*.is_authorized'    => 'required|boolean'
        ];
    }
}
