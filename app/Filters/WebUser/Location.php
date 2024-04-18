<?php

namespace App\Filters\WebUser;

use App\Models\WebUser\WebUser;

class Location
{
    public function apply($query, $value): void
    {
        $webUser = WebUser::getModel();

        $query->where($webUser->qualifyColumn('vergidairesi'), 'LIKE', '%' . $value . '%');
    }
}
