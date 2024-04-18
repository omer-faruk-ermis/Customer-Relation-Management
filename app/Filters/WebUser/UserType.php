<?php

namespace App\Filters\WebUser;

use App\Models\WebUser\WebUser;

class UserType
{
    public function apply($query, $value): void
    {
        $webUser = WebUser::getModel();

        $query->where($webUser->qualifyColumn('kullanici_tipi'), '=', $value);
    }
}
