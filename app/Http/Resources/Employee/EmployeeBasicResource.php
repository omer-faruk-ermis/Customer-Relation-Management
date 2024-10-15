<?php

namespace App\Http\Resources\Employee;

use App\Http\Resources\AbstractResource;
use App\Utils\Security;

/**
 * Class EmployeeBasicResource
 *
 * @package App\Http\Resources\Employee
 *
 * @mixin mixed
 */
class EmployeeBasicResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        if ($this->relationLoaded('members')) {
            return [
                'id'         => $this->whenLoaded('members')?->id,
                'full_name'  => $this->whenLoaded('members')?->ad_soyad
            ];
        }

        return [
            'id'         => $this->getKey(),
            'full_name'  => $this->ad_soyad,
            'sip'        => $this?->sip?->first()->sip_id ?? null
        ];
    }
}
