<?php

namespace App\Http\Requests\DetailMenu;

use App\Http\Requests\AbstractRequest;
use App\Utils\Security;

class StoreDetailMenuUserRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['menu_id', 'userid'];

    public function rules(): array
    {
        return [
            'menu_id' => 'required|string',
            'userid'  => 'required|string',
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('menu_id')) {
            $this->merge([
                             'menu_id' => Security::decrypt($this->input('menu_id'))
                         ]);
        }

        if ($this->has('userid')) {
            $this->merge([
                             'userid' => Security::decrypt($this->input('userid'))
                         ]);
        }
    }
}
