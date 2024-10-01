<?php

namespace App\Http\Resources\Reason;

use App\Enums\ReasonType;
use App\Http\Resources\AbstractResource;
use App\Utils\Security;

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
            'id'              => Security::encrypt($this->getKey()),
            'description'     => $this->aciklama,
            'parent_id'       => Security::encrypt($this->ust_id),
            'type'            => $this->ust_id == 0 ? ReasonType::all()[0]->description : ReasonType::all()[1]->description,
            'blacklist_level' => $this->karaliste_seviye,
            'meeting_id'      => $this->gorusme_id,
            'reason_wanted'   => ReasonWantedResource::make($this->whenLoaded('reasonWanted')),
        ];
    }
}
