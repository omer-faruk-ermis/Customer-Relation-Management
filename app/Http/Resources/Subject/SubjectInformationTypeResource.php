<?php

namespace App\Http\Resources\Subject;

use App\Http\Resources\AbstractResource;

/**
 * Class SubjectInformationTypeResource
 *
 * @package App\Http\Resources\Subject
 *
 * @mixin mixed
 */
class SubjectInformationTypeResource extends AbstractResource
{
    /**
     * @param $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'order' => $this->tipid,
            'color' => $this->color,
        ];
    }
}
