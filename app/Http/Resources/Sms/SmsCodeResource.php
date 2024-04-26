<?php

namespace App\Http\Resources\Sms;

use App\Http\Resources\AbstractResource;

/**
 * Class SmsCodeResource
 *
 * @package App\Http\Resources\Sms
 *
 * @mixin mixed
 */
class SmsCodeResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'remaining_otp_time'  => $this->remaining_otp_time,
        ];
    }
}
