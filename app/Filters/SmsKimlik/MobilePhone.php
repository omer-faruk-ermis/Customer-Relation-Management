<?php

namespace App\Filters\SmsKimlik;

use App\Models\SmsKimlik\SmsKimlik;

class MobilePhone
{
    public function apply($query, $value): void
    {
        $smsKimlik = SmsKimlik::getModel();

        $query->whereLike($smsKimlik->qualifyColumn('ceptel'), $value);
    }
}
