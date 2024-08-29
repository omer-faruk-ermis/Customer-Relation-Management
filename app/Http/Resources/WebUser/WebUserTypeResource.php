<?php

namespace App\Http\Resources\WebUser;

use App\Http\Resources\AbstractResource;

/**
 * Class WebUserTypeResource
 *
 * @package App\Http\Resources\WebUser
 *
 * @mixin mixed
 */
class WebUserTypeResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'          => $this->ktip,
            'description' => $this->kaciklama,
            'color'       => $this->kcolor
        ];
    }
}
