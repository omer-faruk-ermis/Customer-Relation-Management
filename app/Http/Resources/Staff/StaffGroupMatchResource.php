<?php

namespace App\Http\Resources\Staff;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeBasicResource;
use App\Http\Resources\Employee\EmployeeResource;
use App\Utils\DateUtil;
use App\Utils\Security;

/**
 * Class StaffGroupMatchResource
 *
 * @package App\Http\Resources\Staff
 *
 * @mixin mixed
 */
class StaffGroupMatchResource extends AbstractResource
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
            'staff_id'       => Security::encrypt($this->personel_id),
            'staff_group_id' => Security::encrypt($this->personel_grup_id),
            'state'          => $this->durum,
            'register_date'  => DateUtil::dateFormat($this->kayit_tarihi),
            'recorder'       => EmployeeBasicResource::make($this->whenLoaded('recorder')),
            'staff'          => EmployeeResource::make($this->whenLoaded('staff')),
        ];
    }
}
