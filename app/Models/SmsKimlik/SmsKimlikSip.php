<?php

namespace App\Models\SmsKimlik;

use App\Models\AbstractModel;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class SmsKimlikSip
 *
 * @package App\Models\SmsKimlik
 * @version April 19, 2024, 1:11 pm UTC
 *
 * @property int            $id
 * @property int            $sms_kimlik
 * @property int            $sip_id
 * @property bool           $mesajgitmesin
 *
 * @property-read SmsKimlik $employee
 */
class SmsKimlikSip extends AbstractModel
{
    protected $table = 'kaynaksms.dbo.sms_kimlik_sip';

    protected $fillable = [
        'sms_kimlik',
        'sip_id',
        'mesajgitmesin'
    ];

    /**
     * @return hasOne
     */
    public function employee(): hasOne
    {
        return $this->hasOne(SmsKimlik::class, 'id', 'sms_kimlik')
                    ->active();
    }
}
