<?php

namespace App\Http\Requests\Staff;

class BulkStaffGroupMatchRequest extends StoreStaffGroupMatchRequest
{
    /*
    protected $fieldsToDecrypt = [
        'bulk_authorizations' => [
            'staff_group_id',
            'staff_id'
        ]
    ];
    */

    public function rules(): array
    {
        return [
            'bulk_authorizations'                  => 'required|array',
            'bulk_authorizations.*.staff_group_id' => 'required|integer',
            'bulk_authorizations.*.staff_id'       => 'required|integer',
            'bulk_authorizations.*.is_authorized'  => 'required|boolean',
        ];
    }
}
