<?php

namespace App\Http\Resources\Subject;

use App\Http\Resources\AbstractCollection;

/**
 * Class SubjectInformationCollection
 *
 * @package App\Http\Resources\Subject
 *
 * @mixin mixed
 */
class SubjectInformationCollection extends AbstractCollection
{
    public $collects = SubjectInformationResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
