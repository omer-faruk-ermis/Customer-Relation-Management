<?php

namespace App\Http\Resources\Subject;

use App\Http\Resources\AbstractResource;

/**
 * Class SubjectInformationUsePlaceResource
 *
 * @package App\Http\Resources\Subject
 *
 * @mixin mixed
 */
class SubjectInformationUsePlaceResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'    => $this->getKey(),
            'name'  => $this->adi,
            'state' => $this->durum,
        ];
    }
}
