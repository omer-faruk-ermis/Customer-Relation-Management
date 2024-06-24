<?php

namespace App\Filters\Call;

use App\Models\Voice\SesUser;

class UserType
{
    public function apply($query, $value): void
    {
        $sesUser = SesUser::getModel();
        $query->where($sesUser->qualifyColumn('kul_tur'), '=', $value);
    }
}
