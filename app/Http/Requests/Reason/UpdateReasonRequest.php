<?php

namespace App\Http\Requests\Reason;

use App\Http\Requests\AbstractRequest;

class UpdateReasonRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'logid'    => 'required',
            'sebep_id' => 'required',
            'kayit_id' => 'sometimes|integer',
            'kayit_ip' => 'sometimes|ip',
            'aciklama' => 'sometimes'
        ];
    }
}
