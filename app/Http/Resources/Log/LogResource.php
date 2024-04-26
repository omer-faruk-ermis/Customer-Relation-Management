<?php

namespace App\Http\Resources\Log;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Resources\Reason\ReasonWantedResource;

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
            'id'            => $this->getKey(),
            'user_id'       => $this->userid,
            'register_id'   => $this->kayitid,
            'before'        => $this->i1,
            'after'         => $this->i2,
            'ip'            => $this->ip,
            'date'          => $this->tarih,
            'looked_at'     => $this->bakildi,
            'employee'      => EmployeeResource::make($this->whenLoaded('employee')),
            'reason_log'    => ReasonLogResource::collection($this->whenLoaded('reasonLog')),
            'reason_wanted' => ReasonWantedResource::make($this->whenLoaded('reasonWanted')),
        ];
    }
}
