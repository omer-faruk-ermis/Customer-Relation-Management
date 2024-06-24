<?php

namespace App\Http\Resources\Call;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Resources\VoiceUser\VoiceUserResource;
use App\Utils\DateUtil;
use App\Utils\Security;
use Illuminate\Support\Carbon;

/**
 * Class CallResource
 *
 * @package App\Http\Resources\Call
 *
 * @mixin mixed
 */
class CallResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'             => Security::encrypt($this->cagri_id),
            'call_direction' => $this->cagri_yonu,
            'call_phone'     => $this->cagri_tel,
            'start_date'     => DateUtil::dateFormat($this->bas_tar),
            'end_date'       => DateUtil::dateFormat($this->bit_tar),
            'recording_time' => Carbon::createFromTimestampUTC($this->billsec)->toTimeString(),
            'brand'          => $this->cagri_sube,
            'voice_record'   => $this->seskayit,
            'user_type'      => $this->user_type,
            'user_name'      => $this->user_name,
            'user_phone'     => $this->user_phone,
            'operator'       => EmployeeResource::make($this->whenLoaded('operator')),
            'voiceUser'      => VoiceUserResource::make($this->whenLoaded('voiceUser')),
        ];
    }
}
