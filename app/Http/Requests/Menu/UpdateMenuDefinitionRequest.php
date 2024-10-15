<?php

namespace App\Http\Requests\Menu;

use App\Http\Requests\AbstractRequest;

class UpdateMenuDefinitionRequest extends AbstractRequest
{
    /*
    protected $fieldsToDecrypt = ['module_id'];
    */

    public function rules(): array
    {
        return [
            'name'      => 'sometimes|string',
            'path'      => 'sometimes|string',
            'icon'      => 'sometimes|string',
            'color'     => 'sometimes|string',
            'module_id' => 'sometimes|string',
        ];
    }
}
