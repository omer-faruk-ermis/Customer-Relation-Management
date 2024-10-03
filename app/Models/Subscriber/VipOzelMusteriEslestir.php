<?php

namespace App\Models\Subscriber;

use App\Filters\Subscriber\VipSpecialCustomerFilter;
use App\Models\AbstractModel;
use App\Models\SmsKimlik\SmsKimlikSip;
use App\Models\WebUser\WebUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class VipOzelMusteriEslestir
 *
 * @package App\Models\Subscriber
 * @version October 02, 2024, 01:49 pm UTC
 *
 * @property int               $id
 * @property int               $dahili
 * @property int               $userid
 * @property int               $durum
 * @property string            $tarih
 * @property string            $aciklama
 * @property int               $tip
 *
 * @property-read WebUser      $webUser
 * @property-read SmsKimlikSip $sip
 *
 * @method static Builder|VipOzelMusteriEslestir filter(array $filters = [])
 */
class VipOzelMusteriEslestir extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.vip_ozel_musteri_eslestir';

    protected $fillable = [
        'dahili',
        'userid',
        'durum',
        'tarih',
        'aciklama',
        'tip'
    ];

    /**
     * @return hasOne
     */
    public function webUser(): hasOne
    {
        return $this->hasOne(WebUser::class, 'id', 'userid');
    }

    /**
     * @return hasMany
     */
    public function sip(): hasMany
    {
        return $this->hasMany(SmsKimlikSip::class, 'sip_id', 'dahili');
    }

    /**
     * @param $filters
     *
     * @return VipSpecialCustomerFilter
     */
    protected function filter($filters): VipSpecialCustomerFilter
    {
        return new VipSpecialCustomerFilter($filters);
    }
}
