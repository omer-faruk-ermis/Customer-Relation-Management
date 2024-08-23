<?php

namespace App\Http\Requests\Url;

use App\Http\Requests\AbstractRequest;

class UpdateUrlDefinitionRequest extends AbstractRequest
{
    protected $fieldsToDecrypt = ['menu_id', 'background_id'];

    public function rules(): array
    {
        return [
            'url'           => 'required|string',
            'name'          => 'required|string',
            'menu_id'       => 'sometimes|string',
            'background_id' => 'sometimes|string',
            'icon'          => 'sometimes|string',
            'color'         => 'sometimes|string',
        ];
    }
}
