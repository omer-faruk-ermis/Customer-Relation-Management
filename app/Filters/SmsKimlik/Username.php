<?php

namespace App\Filters\SmsKimlik;

use App\Models\SmsKimlik\SmsKimlik;

class Username
{
    public function apply($query, $value): void
    {
        $smsKimlik = SmsKimlik::getModel();

        $query->whereLike($smsKimlik->qualifyColumn('sms_kimlik_email_username'), $value);
    }
}
