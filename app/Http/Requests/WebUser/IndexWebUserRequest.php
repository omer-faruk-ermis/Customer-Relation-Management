<?php

namespace App\Http\Requests\WebUser;

use Illuminate\Foundation\Http\FormRequest;

class IndexWebUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'location'        => 'sometimes|string',
            'user_type'       => 'sometimes|string',
            'agreement_state' => [
                'sometimes',
                'string',
                'in:0,1,2,*',
                function ($attribute, $value) {
                    if ($value == '*') {
                        $this->request->remove($attribute);
                    }
                },
            ],
        ];
    }
}
