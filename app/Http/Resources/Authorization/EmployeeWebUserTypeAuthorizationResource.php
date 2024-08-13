<?php

namespace App\Http\Resources\Authorization;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeBasicResource;
use App\Utils\Security;

/**
 * Class EmployeeWebUserTypeAuthorizationResource
 *
 * @package App\Http\Resources\Authorization
 *
 * @mixin mixed
 */
class EmployeeWebUserTypeAuthorizationResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'employee_id'         => Security::encrypt($this->sms_kimlik),
            'web_user_type'       => $this->webuser_tip,
            'operator_code'       => $this->kopkodu,
            'state'               => $this->durum,
            'is_authorized'       => true,
            'operator_name'       => $this->adi,
            'operator_short_name' => $this->kisa_ad,
            'web_user_type_name'  => $this->kaciklama,
            'recorder'            => EmployeeBasicResource::make($this->whenLoaded('recorder')),
        ];
    }
}
