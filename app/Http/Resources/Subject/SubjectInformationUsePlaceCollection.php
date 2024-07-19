<?php

namespace App\Http\Resources\Subject;

use App\Http\Resources\AbstractCollection;

/**
 * Class SubjectInformationUsePlaceCollection
 *
 * @package App\Http\Resources\Subject
 *
 * @mixin mixed
 */
class SubjectInformationUsePlaceCollection extends AbstractCollection
{
    public $collects = SubjectInformationUsePlaceResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
