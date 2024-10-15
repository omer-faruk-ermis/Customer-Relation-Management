<?php

namespace App\Http\Resources\WebPortal;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeBasicResource;
use App\Utils\DateUtil;
use App\Utils\Security;

/**
 * Class WebPortalAuthorizationPermissionResource
 *
 * @package App\Http\Resources\WebPortal
 *
 * @mixin mixed
 */
class WebPortalAuthorizationPermissionResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                 => $this->getKey(),
            'authorization_id'   => $this->yetki_id,
            'employee_id'        => $this->userid,
            'additional_user_id' => $this->ekuserid,
            'state'              => $this->durum,
            'date'               => DateUtil::dateFormat($this->tarih),
            'members'            => EmployeeBasicResource::make($this->whenLoaded('members')),
        ];
    }
}
