<?php

namespace App\Builder;

use App\Models\SmsKimlik\SmsKimlik;
use App\Services\Authorization\AuthorizationService;
use Illuminate\Support\Arr;

class SmsKimlikBuilder
{
    /**
     * @param $sms_kimlik
     *
     * @return SmsKimlik
     */
    public static function handle($sms_kimlik): SmsKimlik
    {
        $sms_kimlik = Arr::add($sms_kimlik, 'dbname', getenv('DSN'));
        $sms_kimlik = Arr::add($sms_kimlik, 'sms_kimlik', $sms_kimlik['id']);
        $sms_kimlik = Arr::add($sms_kimlik, 'personelkimlik', $sms_kimlik['id']);
        $sms_kimlik = Arr::add($sms_kimlik, 'sipid', $sms_kimlik['sip'][0]['sip_id']);
        $sms_kimlik = Arr::add($sms_kimlik, 'user_authenticated', 540);
        $sms_kimlik = Arr::add($sms_kimlik, 'authorizations', (new AuthorizationService($sms_kimlik['id']))->getAuthorizations());
        $sms_kimlik = Arr::add($sms_kimlik, 'yetki_string', (new AuthorizationService($sms_kimlik['id'], true))->getAuthorizationString());

        return $sms_kimlik;
    }
}
