<?php

namespace App\Http\Resources\VoiceUser;

use App\Http\Resources\AbstractResource;

/**
 * Class PathResource
 *
 * @package App\Http\Resources\VoiceUser
 *
 * @mixin mixed
 */
class PathResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'path' => $this->path
        ];
    }
}
