<?php

namespace App\Http\Resources\Dealer;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\WebUser\WebUserTypeResource;
use App\Utils\Security;

/**
 * Class DealerResource
 *
 * @package App\Http\Resources\Dealer
 *
 * @mixin mixed
 */
class DealerResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                => $this->getKey(),
            'name'              => $this->ad,
            'surname'           => $this->soyad,
            'full_name'         => $this->full_name,
            'subscription_no'   => $this->abone_no,
            'subscription_type' => $this->abonetip,
            'corporation_name'  => $this->kurumadi,
            'user_type'         => WebUserTypeResource::make($this->whenLoaded('userType')),
        ];
    }
}
