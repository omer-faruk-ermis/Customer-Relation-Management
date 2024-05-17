<?php

namespace App\Http\Resources\Staff;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeBasicResource;
use App\Utils\DateUtil;
use App\Utils\Security;

/**
 * Class StaffGroupResource
 *
 * @package App\Http\Resources\Staff
 *
 * @mixin mixed
 */
class StaffGroupResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'             => Security::encrypt($this->getKey()),
            'name'           => $this->grup_adi,
            'state'          => $this->durum,
            'description'    => $this->aciklama,
            'register_date'  => DateUtil::dateFormat($this->kayit_tarihi),
            'recorder'       => EmployeeBasicResource::make($this->whenLoaded('recorder')),
            'members'        => StaffGroupMatchResource::collection($this->whenLoaded('members')),
            'authorizations' => StaffGroupAuthorizationMatchResource::collection($this->whenLoaded('authorizations')),
        ];
    }
}
