<?php

namespace App\Http\Requests\Url;

use App\Http\Requests\AbstractRequest;

class StoreUrlDefinitionRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['menu_id', 'background_id'];

    public function rules(): array
    {
        return [
            'url'           => 'required|string',
            'name'          => 'required|string',
            'menu_id'       => 'required|string',
            'background_id' => 'required|string',
            'icon'          => 'sometimes|string',
            'color'         => 'sometimes|string',
        ];
    }
}
