<?php

namespace App\Http\Resources\WebPortal;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeBasicResource;
use App\Utils\DateUtil;
use App\Utils\Security;

/**
 * Class WebPortalAuthorizationResource
 *
 * @package App\Http\Resources\WebPortal
 *
 * @mixin mixed
 */
class WebPortalAuthorizationResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                   => Security::encrypt($this->getKey()),
            'description'          => $this->aciklama,
            'state'                => $this->durum,
            'date'                 => DateUtil::dateFormat($this->tarih),
            'definition'           => $this->tanim,
            'authorization_detail' => $this->yetki_detay,
            'is_authorized'        => $this->is_authorized,
            'menu_id'              => Security::encrypt($this->menu_id),
            'type'                 => $this->tip,
            'members'              => EmployeeBasicResource::collection($this->whenLoaded('members')),
        ];
    }
}
