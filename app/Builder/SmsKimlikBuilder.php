<?php

namespace App\Builder;

use App\Models\SmsKimlik\SmsKimlik;
use Illuminate\Support\Arr;

class SmsKimlikBuilder
{
    /**
     * @param $sms_kimlik
     * @return SmsKimlik
     */
    public static function handle($sms_kimlik): SmsKimlik
    {
        $sms_kimlik = Arr::add($sms_kimlik, 'dbname', getenv('DSN'));
        $sms_kimlik = Arr::add($sms_kimlik, 'sms_kimlik', $sms_kimlik['id']);
        $sms_kimlik = Arr::add($sms_kimlik, 'personelkimlik', $sms_kimlik['id']);
        $sms_kimlik = Arr::add($sms_kimlik, 'sipid', $sms_kimlik['sip'][0]['sip_id']);
        $sms_kimlik = Arr::add($sms_kimlik, 'user_authenticated', 540);

        return $sms_kimlik;
    }
}
