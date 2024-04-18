<?php

namespace App\Builder;

use App\Models\SmsKimlik\SmsKimlik;
use App\Models\SmsKimlik\SmsKimlikBirim;
use App\Models\SmsKimlik\SmsKimlikSip;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SmsKimlikBuilder
{
    /**
     * @param $sms_kimlik
     * @return SmsKimlik
     */
    public static function handle($sms_kimlik): SmsKimlik
    {
        $sms_kimlik_sip =
            SmsKimlikSip::select(DB::raw('MAX(id) as max_id'), 'sip_id')
                ->where('sms_kimlik', '=', $sms_kimlik['id'])
                ->orderByDesc('max_id')
                ->groupBy('sip_id')
                ->pluck('sip_id')
                ->first();

        $sms_kimlik['birim'] = SmsKimlikBirim::select('birim')
            ->where('id', '=', $sms_kimlik->birim_id)
            ->pluck('birim')
            ->first();

        $sms_kimlik = Arr::add($sms_kimlik, 'dbname', getenv('DSN'));
        $sms_kimlik = Arr::add($sms_kimlik, 'sms_kimlik', $sms_kimlik['id']);
        $sms_kimlik = Arr::add($sms_kimlik, 'personelkimlik', $sms_kimlik['id']);
        $sms_kimlik = Arr::add($sms_kimlik, 'sipid', $sms_kimlik_sip);
        $sms_kimlik = Arr::add($sms_kimlik, 'user_authenticated', 540);

        return $sms_kimlik;
    }
}
