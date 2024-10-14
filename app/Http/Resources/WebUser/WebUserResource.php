<?php

namespace App\Http\Resources\WebUser;

use App\Enums\UserModel;
use App\Http\Resources\AbstractResource;
use App\Http\Resources\Dealer\DealerResource;
use App\Http\Resources\Subscriber\SubscriberNoResource;
use App\Utils\Security;

/**
 * Class WebUserResource
 *
 * @package App\Http\Resources\WebUser
 *
 * @mixin mixed
 */
class WebUserResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        $userModel = array_filter([
                                      UserModel::VIP     => $this->whenLoaded(UserModel::VIP),
                                      UserModel::PILOT   => $this->whenLoaded(UserModel::PILOT),
                                      UserModel::SPECIAL => $this->whenLoaded(UserModel::SPECIAL),
                                  ]);

        return [
            'id'                => Security::encrypt($this->getKey()),
            'web_user_id'       => $this->getKey(),
            'user_name'          => $this->name,
            'name'              => $this->ad,
            'surname'           => $this->soyad,
            'full_name'         => $this->full_name,
            'mobile_phone'      => $this->ceptel,
            'identity_no'       => $this->tckimlik,
            'subscription_no'   => $this->abone_no,
            'subscription_type' => $this->abonetip,
            'user_model'        => $userModel,
            'use_type'          => $this->use_type,
            'agreement'         => $this->agreement_type,
            'corporation'       => $this->kurumadi ? [
                'id'   => $this->corporationType?->id,
                'type' => $this->corporationType?->tur_isim,
                'name' => $this->kurumadi,
            ] : null,
            'user_type'         => WebUserTypeResource::make($this->whenLoaded('userType')),
            'subscriber_no'     => SubscriberNoResource::make($this->whenLoaded('subscriberNo')),
            'dealer'            => DealerResource::make($this->whenLoaded('dealer')),
        ];
    }
}
