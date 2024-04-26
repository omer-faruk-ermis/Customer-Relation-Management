<?php

namespace App\Http\Resources\Reason;

use App\Http\Resources\AbstractResource;

/**
 * Class ReasonResource
 *
 * @package App\Http\Resources\Reason
 *
 * @mixin mixed
 */
class ReasonResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'              => $this->getKey(),
            'description'     => $this->aciklama,
            'upper_id'        => $this->ust_id,
            'blacklist_level' => $this->karaliste_seviye,
            'meeting_id'      => $this->gorusme_id,
        ];
    }
}
