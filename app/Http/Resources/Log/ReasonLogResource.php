<?php

namespace App\Http\Resources\Log;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Reason\ReasonResource;
use App\Utils\DateUtil;

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
            'register_date' => DateUtil::dateFormat($this->kayit_tar),
            'meeting_id'    => $this->gorusme_id,
            'reason'        => ReasonResource::make($this->whenLoaded('reason')),
        ];
    }
}
