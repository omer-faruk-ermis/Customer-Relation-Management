<?php

namespace App\Http\Requests\Staff;

use App\Enums\Authorization\AuthorizationType;
use App\Http\Requests\AbstractRequest;
use App\Models\Staff\PersonelGrupYetkiEslestir;
use Illuminate\Validation\Rule;

class StoreStaffGroupAuthorizationMatchRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['staff_group_id', 'authorization_id'];
    */

    public function rules(): array
    {
        $extraRules = [
            'staff_group_id'   => ['integer', 'required'],
            'authorization_id' => ['integer', 'required'],
            'type'             => ['integer', 'required'],
        ];

        return array_merge_recursive(PersonelGrupYetkiEslestir::$ensRules, PersonelGrupYetkiEslestir::$rules, $extraRules);
    }
}
