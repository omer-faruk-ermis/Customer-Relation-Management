<?php

namespace App\Http\Resources\Subscriber;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeResource;
use App\Http\Resources\Log\ReasonLogResource;
use App\Http\Resources\Reason\ReasonWantedResource;
use App\Utils\Security;

/**
 * Class SubscriberBilletAuthorizationResource
 *
 * @package App\Http\Resources\Subscriber
 *
 * @mixin mixed
 */
class SubscriberBilletAuthorizationResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'            => Security::encrypt($this->getKey()),
            'description'   => $this->aciklama,
            'state'         => $this->durum,
        ];
    }
}
