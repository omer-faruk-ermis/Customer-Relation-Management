<?php

namespace App\Models\Authorization;

use App\Models\AbstractModel;
use App\Models\RecorderTrait;

/**
 * Class SmsKimlikWebUserTipYetki
 *
 * @package App\Models\Authorization
 * @version August 07, 2024, 0:20 pm UTC
 *
 * @property int    $id
 * @property int    $sms_kimlik
 * @property int    $webuser_tip
 * @property int    $kopkodu
 * @property int    $kayit_id
 * @property string $kayit_ip
 * @property string $kayit_tarih
 * @property int    $durum
 */
class SmsKimlikWebUserTipYetki extends AbstractModel
{
    protected $table = 'kaynaksms.dbo.sms_kimlik_webuser_tip_yetki';

    use RecorderTrait;

    protected $fillable = [
        'sms_kimlik',
        'webuser_tip',
        'kopkodu',
        'kayit_id',
        'kayit_ip',
        'kayit_tarih',
        'durum'
    ];

    protected $casts = [
        'sms_kimlik'  => 'integer',
        'webuser_tip' => 'integer',
        'kopkodu'     => 'integer',
    ];
}
