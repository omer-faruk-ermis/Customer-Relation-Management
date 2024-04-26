<?php

namespace App\Models\SmsKimlik;

use App\Models\AbstractModel;

/**
 * Class SmsKimlikSip
 *
 * @package App\Models\SmsKimlik
 * @version April 19, 2024, 1:11 pm UTC
 *
 * @property int  $id
 * @property int  $sms_kimlik
 * @property int  $sip_id
 * @property bool $mesajgitmesin
 */
class SmsKimlikSip extends AbstractModel
{
    protected $table = 'kaynaksms.dbo.sms_kimlik_sip';

    protected $fillable = [
        'sms_kimlik',
        'sip_id',
        'mesajgitmesin'
    ];
}
