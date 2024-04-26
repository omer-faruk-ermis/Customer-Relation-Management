<?php

namespace App\Http\Resources\Log;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Reason\ReasonResource;

/**
 * Class ReasonLogResource
 *
 * @package App\Http\Resources\Log
 *
 * @mixin mixed
 */
class ReasonLogResource extends AbstractResource
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
            'description'   => $this->aciklama,
            'register_ip'   => $this->kayit_ip,
            'register_date' => $this->kayit_tar,
            'meeting_id'    => $this->gorusme_id,
            'reason_log'    => ReasonResource::make($this->whenLoaded('reason')),
        ];
    }
}
