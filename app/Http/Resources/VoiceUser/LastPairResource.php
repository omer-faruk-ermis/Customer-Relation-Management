<?php

namespace App\Http\Resources\VoiceUser;

use App\Http\Resources\AbstractResource;

/**
 * Class LastPairResource
 *
 * @package App\Http\Resources\VoiceUser
 *
 * @mixin mixed
 */
class LastPairResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'call_phone' => $this->ceptel
        ];
    }
}
