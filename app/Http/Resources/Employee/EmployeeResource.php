<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Module\ModuleResource;

/**
 * Class EmployeeResource
 *
 * @package App\Http\Resources\Employee
 *
 * @mixin mixed
 */
class EmployeeResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                    => $this->getKey(),
            'full_name'             => $this->ad_soyad,
            'login_permission'      => $this->loginpage,
            'state'                 => $this->durum,
            'sip'                   => EmployeeSipResource::collection($this->whenLoaded('sip')),
            'unit'                  => EmployeeUnitResource::make($this->whenLoaded('unit')),
            'unit_id'               => $this->birim_id,
            'sip_id'                => $this->sip_id,
            'web_user_id'           => $this->webuserid,
            'currency_limit'        => $this->para_limit,
            'web_portal_permission' => $this->webportal_izin,
            'mobile_phone'          => $this->ceptel,
            'email'                 => $this->sms_kimlik_email,
            'home_phone'            => $this->evtel,
            'netgsmsessionid'       => $this->netgsmsessionid,
            'module'                => ModuleResource::collection($this->module ?? []),
        ];
    }
}
