<?php

namespace App\Http\Resources\Staff;

use App\Http\Resources\AbstractCollection;
use App\Utils\Security;

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
        $this->collection = $this->collection->map(function ($menu) use ($request) {
            $menu->is_authorized = in_array(Security::decrypt($request->input('employee_id')), $menu->members->pluck('personel_id')->toArray());

            return $menu;
        });

        return $this->collection;
    }
}
