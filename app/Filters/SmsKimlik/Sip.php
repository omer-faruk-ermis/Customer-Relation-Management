<?php

namespace App\Filters\SmsKimlik;

use App\Models\SmsKimlik\SmsKimlikSip;

class Sip
{
    public function apply($query, $value): void
    {
        $smsKimlikSip = SmsKimlikSip::getModel();

        $query->where($smsKimlikSip->qualifyColumn('sip_id'), '=', $value);
    }
}
