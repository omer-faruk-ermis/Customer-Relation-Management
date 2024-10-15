<?php

namespace App\Models\Voice;

use App\Models\AbstractModel;
use App\Models\Customer\Musteri;
use App\Models\SmsKimlik\SmsKimlik;
use App\Models\WebUser\WebUser;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class SesUser
 *
 * @package App\Models\Voice
 * @version July 05, 2024, 0:11 pm UTC
 *
 * @property int            $id
 * @property int            $cagri_id
 * @property int            $userid
 * @property int            $eslestiren_id
 * @property string         $eslestiren_ip
 * @property string         $eslesme_tar
 * @property int            $sildurum
 * @property int            $tip
 * @property int            $kul_tur
 * @property int            $gorusme_id
 *
 * @property-read Musteri   $customer
 * @property-read WebUser   $webUser
 * @property-read SmsKimlik $pairedBy
 */
class SesUser extends AbstractModel
{
    protected $table = 'crm.dbo.ses_user';

    protected $fillable = [
        'cagri_id',
        'userid',
        'eslestiren_id',
        'eslestiren_ip',
        'eslesme_tar',
        'sildurum',
        'kul_tur',
        'tip'
    ];

    /**
     * @return hasOne
     */
    public function pairedBy(): hasOne
    {
        return $this->hasOne(SmsKimlik::class, 'id', 'eslestiren_id')
                    ->active();
    }
}
