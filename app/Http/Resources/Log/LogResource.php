<?php

namespace App\Http\Resources\Log;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Resources\Reason\ReasonWantedResource;
use App\Http\Resources\WebUser\WebUserResource;
use App\Utils\DateUtil;
use App\Utils\Security;

/**
 * Class LogResource
 *
 * @package App\Http\Resources\Log
 *
 * @mixin mixed
 */
class LogResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'            => Security::encrypt($this->getKey()),
            'user_id'       => Security::encrypt($this->userid),
            'register_id'   => Security::encrypt($this->kayitid),
            'before'        => $this->i1,
            'after'         => $this->i2,
            'ip'            => $this->ip,
            'date'          => DateUtil::dateFormat($this->tarih),
            'looked_at'     => $this->bakildi,
            'webUser'       => WebUserResource::make($this->whenLoaded('webUser')),
            'employee'      => EmployeeResource::make($this->whenLoaded('employee')),
            'reason_log'    => ReasonLogResource::collection($this->whenLoaded('reasonLog')),
            'reason_wanted' => ReasonWantedResource::make($this->whenLoaded('reasonWanted')),
        ];
    }
}
