<?php

namespace App\Http\Resources\Dealer;

use App\Http\Resources\AbstractResource;
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
            'id'                => Security::encrypt($this->getKey()),
            'name'              => $this->ad,
            'surname'           => $this->soyad,
            'full_name'         => $this->full_name,
            'user_type'         => $this->kullanici_tipi,
            'subscription_no'   => $this->abone_no,
            'subscription_type' => $this->abonetip,
            'corporation_name'  => $this->kurumadi,
        ];
    }
}
