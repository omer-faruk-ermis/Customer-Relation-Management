<?php

namespace App\Models\SmsKimlik;

use App\Models\AbstractModel;

/**
 * Class SmsKimlikSip
 *
 * @package App\Models
 */
class SmsKimlikSip extends AbstractModel
{
    protected $table = 'kaynaksms.dbo.sms_kimlik_sip';

    protected $fillable = ['sms_kimlik','sip_id', 'mesajgitmesin'];
}
