<?php

namespace App\Http\Resources\Reason;

use App\Http\Resources\AbstractResource;
use App\Utils\Security;

/**
 * Class ReasonWantedResource
 *
 * @package App\Http\Resources\Reason
 *
 * @mixin mixed
 */
class ReasonWantedResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'              => $this->getKey(),
            'phrase'          => $this->ifade,
        ];
    }
}
