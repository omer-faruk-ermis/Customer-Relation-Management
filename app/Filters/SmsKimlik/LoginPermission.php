<?php

namespace App\Filters\SmsKimlik;

use App\Models\SmsKimlik\SmsKimlik;

class LoginPermission
{
    public function apply($query, $value): void
    {
        $smsKimlik = SmsKimlik::getModel();

        $query->where($smsKimlik->qualifyColumn('loginpage'), '=', $value);
    }
}
