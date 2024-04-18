<?php

namespace App\Filters\SmsKimlik;

use App\Models\SmsKimlik\SmsKimlik;

class WebPortalPermission
{
    public function apply($query, $value): void
    {
        $smsKimlik = SmsKimlik::getModel();

        $query->where($smsKimlik->qualifyColumn('webportal_izin'), '=', $value);
    }
}
