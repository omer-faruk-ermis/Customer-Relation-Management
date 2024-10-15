<?php

namespace App\Http\Requests\Staff;

use App\Http\Requests\Authorization\BulkEmployeeAuthorizationRequest;

class BulkStaffGroupAuthorizationMatchRequest extends BulkEmployeeAuthorizationRequest
{
    /*
    protected $fieldsToDecrypt = [
        'bulk_authorizations' => [
            'staff_group_id',
            'authorization_id'
        ]
    ];
    */

    public function rules(): array
    {
        return [
            'bulk_authorizations'                    => 'required|array',
            'bulk_authorizations.*.staff_group_id'   => 'required|integer',
            'bulk_authorizations.*.authorization_id' => 'required|integer',
            'bulk_authorizations.*.is_authorized'    => 'required|boolean',
            'bulk_authorizations.*.type'             => 'required|integer'
        ];
    }
}
