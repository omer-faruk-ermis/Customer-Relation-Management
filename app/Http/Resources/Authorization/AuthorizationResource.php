<?php

namespace App\Http\Resources\Authorization;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeBasicResource;
use App\Utils\Security;

/**
 * Class StaffGroupAuthorizationMatchResource
 *
 * @package App\Http\Resources\Staff
 *
 * @mixin mixed
 */
class AuthorizationResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'               => $this->match_id,
            'staff_group_id'   => $this->staff_group_id,
            'authorization_id' => $this->id,
            'menu_id'          => $this->menu_id ?? null,
            'name'             => $this->name,
            'url'              => $this->url ?? null,
            'menu'             => $this->menu,
            'state'            => $this->match_state,
            'type'             => $this->match_type,
            'is_authorized'    => $this->is_authorized,
            'recorder'         => EmployeeBasicResource::make($this->recorder),
        ];
    }
}
