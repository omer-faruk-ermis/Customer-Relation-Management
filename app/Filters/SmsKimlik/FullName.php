<?php

namespace App\Filters\SmsKimlik;

use App\Models\SmsKimlik\SmsKimlik;

class FullName
{
    public function apply($query, $value): void
    {
        $smsKimlik = SmsKimlik::getModel();

        $query->whereLike($smsKimlik->qualifyColumn('ad_soyad'), $value);
    }
}
