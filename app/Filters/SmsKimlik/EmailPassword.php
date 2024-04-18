<?php

namespace App\Filters\SmsKimlik;

use App\Models\SmsKimlik\SmsKimlik;

class EmailPassword
{
    public function apply($query, $value): void
    {
        $smsKimlik = SmsKimlik::getModel();

        $query->where($smsKimlik->qualifyColumn('sms_kimlik_email_password'), '=', $value);
    }
}
