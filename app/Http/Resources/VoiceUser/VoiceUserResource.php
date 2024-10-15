<?php

namespace App\Http\Resources\VoiceUser;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeResource;
use App\Utils\DateUtil;
use App\Utils\Security;

/**
 * Class VoiceUserResource
 *
 * @package App\Http\Resources\VoiceUser
 *
 * @mixin mixed
 */
class VoiceUserResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'        => $this->id,
            'call_id'   => $this->cagri_id,
            'user_id'   => $this->userid,
            'pair_date' => DateUtil::dateFormat($this->eslesme_tar),
            'type'      => $this->tip,
            'user_type' => $this->kul_tur,
            'paired_by' => EmployeeResource::make($this->whenLoaded('pairedBy')),
        ];
    }
}
