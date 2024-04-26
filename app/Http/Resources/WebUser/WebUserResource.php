<?php

namespace App\Http\Resources\WebUser;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeResource;

/**
 * Class WebUserResource
 *
 * @package App\Http\Resources\WebUser
 *
 * @mixin mixed
 */
class WebUserResource extends AbstractResource
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
            'mobile_phone'      => $this->ceptel,
            'user_type_id'      => $this->kullanici_tipi,
            'identity_no'       => $this->tckimlik,
            'subscription_no'   => $this->abone_no,
            'subscription_type' => $this->abonetip,
            'corporation_name'  => $this->kurumadi,
        ];
    }
}
