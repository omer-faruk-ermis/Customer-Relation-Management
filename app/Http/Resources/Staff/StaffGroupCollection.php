<?php

namespace App\Http\Resources\Staff;

use App\Http\Resources\AbstractCollection;

/**
 * Class StaffGroupCollection
 *
 * @package App\Http\Resources\Staff
 *
 * @mixin mixed
 */
class StaffGroupCollection extends AbstractCollection
{
    public $collects = StaffGroupResource::class;

    /**
     * @inheritDoc
     */
    public function toArray($request): object
    {
        return $this->collection;
    }
}
