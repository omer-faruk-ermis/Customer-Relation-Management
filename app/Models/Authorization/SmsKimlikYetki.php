<?php

namespace App\Models\Authorization;

use App\Models\AbstractModel;
use App\Models\RecorderTrait;
use App\Models\SmsKimlik\SmsKimlik;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class SmsKimlikYetki
 *
 * @package App\Models\Authorization
 * @version April 26, 2024, 0:05 pm UTC
 *
 * @property int            $id
 * @property int            $sms_kimlik
 * @property string         $url_id
 * @property int            $kayit_id
 * @property string         $kayit_ip
 *
 * @property-read SmsKimlik $recorder
 */
class SmsKimlikYetki extends AbstractModel
{
    protected $table = 'kaynaksms.dbo.sms_kimlik_yetki';

    use RecorderTrait;

    protected $fillable = [
        'sms_kimlik',
        'url_id',
        'kayit_id',
        'kayit_ip'
    ];

    protected $casts = [
        'url_id'     => 'integer',
        'sms_kimlik' => 'integer',
    ];

    /**
     * @return hasOne
     */
    public function members(): hasOne
    {
        return $this->hasOne(SmsKimlik::class, 'id', 'sms_kimlik');
    }
}
