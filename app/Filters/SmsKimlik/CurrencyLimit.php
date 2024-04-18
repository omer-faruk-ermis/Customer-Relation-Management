<?php

namespace App\Filters\SmsKimlik;

use App\Models\SmsKimlik\SmsKimlik;

class CurrencyLimit
{
    public function apply($query, $value): void
    {
        $smsKimlik = SmsKimlik::getModel();

        $query->where($smsKimlik->qualifyColumn('para_limit'), '<=', $value);
    }
}
