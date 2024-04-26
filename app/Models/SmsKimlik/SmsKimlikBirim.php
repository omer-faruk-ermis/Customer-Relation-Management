<?php

namespace App\Models\SmsKimlik;

use App\Models\AbstractModel;

/**
 * Class SmsKimlikBirim
 *
 * @package App\Models\SmsKimlik
 * @version April 19, 2024, 1:11 pm UTC
 *
 * @property int    $id
 * @property string $birim
 * @property bool   $durum
 */
class SmsKimlikBirim extends AbstractModel
{
    protected $table = 'kaynaksms.dbo.sms_kimlik_birim';
}
