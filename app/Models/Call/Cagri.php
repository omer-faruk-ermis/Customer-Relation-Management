<?php

namespace App\Models\Call;

use App\Filters\Call\CallFilter;
use App\Models\AbstractModel;
use App\Models\SmsKimlik\SmsKimlik;
use App\Models\Voice\SesUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Cagri
 *
 * @package App\Models\Call
 * @version July 05, 2024, 0:11 pm UTC
 *
 * @property int             $id
 * @property int             $cagri_yonu
 * @property string          $cid
 * @property string          $bas_tar
 * @property string          $bit_tar
 * @property string          $seskayit
 * @property bool            $durum
 * @property int             $sube
 * @property int             $sube_kayit_id
 * @property int             $operator_durum
 * @property int             $opid
 * @property string          $operator_ip
 * @property int             $billsec
 * @property int             $nerden
 * @property int             $dahili
 * @property int             $trunk
 *
 * @property-read CagriDetay $detail
 * @property-read SesUser    $voiceUser
 *
 * @method static Builder|Cagri filter(array $filters = [])
 */
class Cagri extends AbstractModel
{
    protected $table = 'crm.dbo.cagri';

    protected $fillable = [];

    /**
     *
     * Last record 2017
     *
     * @return hasMany
     */
    public function detail(): hasMany
    {
        return $this->hasMany(CagriDetay::class, 'ustid', 'id');
    }

    /**
     * @return hasOne
     */
    public function operator(): hasOne
    {
        return $this->hasOne(SmsKimlik::class, 'id', 'opid');
    }

    /**
     * @return hasOne
     */
    public function voiceUser(): hasOne
    {
        return $this->hasOne(SesUser::class, 'cagri_id', 'id');
    }

    /**
     * @param $filters
     *
     * @return CallFilter
     */
    protected function filter($filters): CallFilter
    {
        return new CallFilter($filters);
    }
}
