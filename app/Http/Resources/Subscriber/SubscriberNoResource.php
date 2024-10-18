<?php

namespace App\Http\Resources\Subscriber;

use App\Http\Resources\AbstractResource;

/**
 * Class SubscriberNoResource
 *
 * @package App\Http\Resources\Subscriber
 *
 * @mixin mixed
 */
class SubscriberNoResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'             => $this->getKey(),
            'phone'          => $this->telno,
            'state'          => $this->durum,
            'web_user_id'    => $this->userid,
            'operator_code'  => $this->op_kodu,
            'transported_no' => $this->tasinmis_no,
            'brand_code'     => $this->abno_brandCode,
            'brand_name'     => $this->abno_brandName,
        ];
    }
}
