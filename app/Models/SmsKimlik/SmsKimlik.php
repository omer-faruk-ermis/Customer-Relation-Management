<?php

namespace App\Models\SmsKimlik;

use App\Filters\SmsKimlik\SmsKimlikFilter;
use App\Models\AbstractSmsKimlik;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class SmsKimlik
 *
 * @package App\Models\SmsKimlik
 *
 */
class SmsKimlik extends AbstractSmsKimlik
{
    protected $table = 'kaynaksms.dbo.sms_kimlik';

    protected $fillable = [
        'sms_kimlik_email',
        'sifre',
        'ad_soyad',
        'sifre',
        'loginpage',
        'durum',
        'yetki_type',
        'karel_id',
        'esirket_id',
        'sip_id',
        'birim_id',
        'webuserid',
        'para_limit',
        'webportal_izin',
        'ceptel',
        'sms_kimlik_email',
        'sms_kimlik_email_username',
        'sms_kimlik_email_password',
        'mattermost_id',
        'evtel'
    ];

    protected $hidden = ['sifre'];

    /**
     * @return HasOne
     */
    public function unit(): HasOne
    {
        return $this->hasOne(SmsKimlikBirim::class, 'id', 'birim_id');
    }

    /**
     * @return hasMany
     */
    public function sip(): hasMany
    {
        return $this->hasMany(SmsKimlikSip::class, 'sms_kimlik', 'id');
    }

    /**
     * @param $filters
     * @return SmsKimlikFilter
     */
    protected function filter($filters): SmsKimlikFilter
    {
        return new SmsKimlikFilter($filters);
    }
}
