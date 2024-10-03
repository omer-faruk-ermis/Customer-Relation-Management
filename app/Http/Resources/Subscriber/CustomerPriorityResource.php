<?php

namespace App\Http\Resources\Subscriber;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeSipResource;
use App\Http\Resources\WebUser\WebUserResource;
use App\Utils\Security;

/**
 * Class CustomerPriorityResource
 *
 * @package App\Http\Resources\Subscriber
 *
 * @mixin mixed
 */
class CustomerPriorityResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'          => Security::encrypt($this->getKey()),
            'description' => $this->aciklama,
            'state'       => $this->durum,
            'date'        => $this->tarih,
            'web_user'    => WebUserResource::make($this->whenLoaded('webUser')),
            'sip'         => EmployeeSipResource::collection($this->whenLoaded('sip')),
        ];
    }
}
