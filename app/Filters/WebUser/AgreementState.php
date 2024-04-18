<?php

namespace App\Filters\WebUser;

use App\Models\WebUser\WebUser;

class AgreementState
{
    public function apply($query, $value): void
    {
        $webUser = WebUser::getModel();

        $query->where($webUser->qualifyColumn('sozlesme'), '=', $value);
    }
}
