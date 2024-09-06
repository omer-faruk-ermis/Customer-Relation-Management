<?php

namespace App\Models\SmsKimlik;

use App\Enums\NumericalConstant;
use App\Enums\Status;
use App\Filters\SmsKimlik\SmsKimlikFilter;
use App\Models\AbstractSmsKimlik;
use App\Models\MaskableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class SmsKimlik
 *
 * @package App\Models\SmsKimlik
 * @version April 19, 2024, 1:11 pm UTC
 *
 * @property int                 $id
 * @property string              $ad_soyad
 * @property string              $sifre
 * @property bool                $loginpage
 * @property bool                $durum
 * @property int                 $yetki_type
 * @property int                 $karel_id
 * @property int                 $esirket_id
 * @property int                 $sip_id
 * @property int                 $birim_id
 * @property int                 $webuserid
 * @property float               $para_limit
 * @property bool                $webportal_izin
 * @property int                 $ceptel
 * @property string              $sms_kimlik_email
 * @property int                 $mattermost_id
 * @property int                 $evtel
 *
 * @property-read SmsKimlikSip   $sip
 * @property-read SmsKimlikBirim $unit
 *
 * @method static Builder|SmsKimlik filter(array $filters = [])
 */
class SmsKimlik extends AbstractSmsKimlik
{
    use MaskableTrait;

    protected $table = 'kaynaksms.dbo.sms_kimlik';

    protected $fillable = [
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
        'mattermost_id',
        'evtel'
    ];

    protected $attributes = [
        'durum'          => Status::ACTIVE,
        'yetki_type'     => Status::ACTIVE,
        'karel_id'       => NumericalConstant::ZERO,
        'esirket_id'     => NumericalConstant::ZERO,
        'sip_id'         => NumericalConstant::ZERO,
        'webuserid'      => NumericalConstant::ZERO,
        'webportal_izin' => Status::ACTIVE,
        'mattermost_id'  => NumericalConstant::ZERO,
    ];

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
     *
     * @return SmsKimlikFilter
     */
    protected function filter($filters): SmsKimlikFilter
    {
        return new SmsKimlikFilter($filters);
    }
}
