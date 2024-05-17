<?php

namespace App\Http\Resources\Staff;

use App\Http\Resources\AbstractResource;
use App\Http\Resources\Url\UrlDefinitionResource;
use App\Utils\Security;

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
            'id'               => Security::encrypt($this->getKey()),
            'staff_group_id'   => Security::encrypt($this->personel_grup_id),
            'authorization_id' => Security::encrypt($this->yetki_id),
            'state'            => $this->durum,
            'type'             => $this->tip,
            'sms_management'   => UrlDefinitionResource::collection($this->whenLoaded('smsManagement')),
            'blueScreen'       => UrlDefinitionResource::collection($this->whenLoaded('blueScreen')),
            'authorization'    => UrlDefinitionResource::collection($this->whenLoaded('authorization')),
            'subscriberBillet' => UrlDefinitionResource::collection($this->whenLoaded('subscriberBillet')),
        ];
    }
}
