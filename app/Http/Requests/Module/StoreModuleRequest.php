<?php

namespace App\Http\Requests\Module;

use App\Http\Requests\AbstractRequest;

class StoreModuleRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'name'  => 'required|string',
            'panel' => 'sometimes|string',
            'path'  => 'sometimes|string',
            'icon'  => 'sometimes|string',
            'color' => 'sometimes|string',
        ];
    }
}
