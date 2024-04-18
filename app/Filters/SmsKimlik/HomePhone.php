<?php

namespace App\Filters\SmsKimlik;

use App\Models\SmsKimlik\SmsKimlik;

class HomePhone
{
    public function apply($query, $value): void
    {
        $smsKimlik = SmsKimlik::getModel();

        $query->where($smsKimlik->qualifyColumn('evtel'), 'LIKE', '%' . $value . '%');
    }
}
