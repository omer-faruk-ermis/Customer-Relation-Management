<?php

namespace App\Http\Resources\Blocked;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Employee\EmployeeBasicResource;
use App\Http\Resources\WebUser\WebUserResource;

/**
 * Class BlockedEmailResource
 *
 * @package App\Http\Resources\Blocked
 *
 * @mixin mixed
 */
class BlockedEmailResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                  => $this->getKey(),
            'email'               => $this->mail,
            'description'         => $this->aciklama,
            'process_person'      => EmployeeBasicResource::make($this->whenLoaded('recorder')),
            'subscriber'          => WebUserResource::collection($this->whenLoaded('subscriber')),
            'subscriber_quantity' => $this->subscriber->count(),
        ];
    }
}
