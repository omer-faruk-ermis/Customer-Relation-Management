<?php

namespace App\Models\Log;

use App\Filters\SmsKimlikLog\SmsKimlikLogFilter;
use App\Models\AbstractModel;
use App\Models\Sebep\SebepIstenecekler;
use App\Models\SmsKimlik\SmsKimlik;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class SmsKimlikLog
 *
 * @package App\Models\Log
 * @version April 19, 2024, 2:21 pm UTC
 *
 * @property int            $id
 * @property int            $user_id
 * @property string         $tabloadi
 * @property string         $alanadi
 * @property int            $kayitid
 * @property string         $i1
 * @property string         $i2
 * @property int            $smskimlik
 * @property string         $tarih
 * @property string         $ip
 * @property bool           $durum
 * @property int            $ust_usr
 * @property string         $tarayici
 * @property string         $yol
 * @property string         $kaynak_tablo
 * @property bool           $bakildi
 * @property int            $ekuserid
 *
 * @property-read SebepLog  $reasonLog
 * @property-read SmsKimlik $employee
 *
 * @method static Builder|SmsKimlikLog filter(array $filters = [])
 */
class SmsKimlikLog extends AbstractModel
{
    protected $table = 'kaynaksms.dbo.sms_kimlik_log';

    /**
     * @return HasMany
     */
    public function reasonLog(): HasMany
    {
        return $this->hasMany(SebepLog::class, 'logid', 'id');
    }

    /**
     * @return hasOne
     */
    public function employee(): hasOne
    {
        return $this->hasOne(SmsKimlik::class, 'id', 'smskimlik');
    }

    /**
     * @return hasOne
     */
    public function reasonWanted(): hasOne
    {
        return $this->hasOne(SebepIstenecekler::class, 'tablo_adi', 'tabloadi');
    }

    /**
     * @param $filters
     *
     * @return SmsKimlikLogFilter
     */
    protected function filter($filters): SmsKimlikLogFilter
    {
        return new SmsKimlikLogFilter($filters);
    }
}
