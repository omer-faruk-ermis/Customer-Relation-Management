<?php

namespace App\Http\Resources\Staff;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Url\UrlDefinitionResource;

/**
 * Class StaffGroupAuthorizationMatchResource
 *
 * @package App\Http\Resources\Staff
 *
 * @mixin mixed
 */
class StaffGroupAuthorizationMatchResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'               => $this->getKey(),
            'staff_group_id'   => $this->personel_grup_id,
            'authorization_id' => $this->yetki_id,
            'state'            => $this->durum,
            'type'             => $this->tip,
            'sms_management'   => UrlDefinitionResource::collection($this->whenLoaded('smsManagement')),
            'blueScreen'       => UrlDefinitionResource::collection($this->whenLoaded('blueScreen')),
            'authorization'    => UrlDefinitionResource::collection($this->whenLoaded('authorization')),
            'subscriberBillet' => UrlDefinitionResource::collection($this->whenLoaded('subscriberBillet')),
        ];
    }
}
