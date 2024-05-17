<?php

namespace App\Http\Requests\Staff;

use App\Http\Requests\AbstractRequest;
use App\Utils\Security;

class StoreStaffGroupRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['recorder_id'];

    public function rules(): array
    {
        return [
            'name'        => 'required|string',
            'description' => 'sometimes|string',
            'state'       => 'required|boolean',
            'recorder_id' => 'required|string',
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('recorder_id')) {
            $this->merge([
                             'recorder_id' => Security::decrypt($this->input('recorder_id'))
                         ]);
        }
    }
}
