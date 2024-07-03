<?php

namespace App\Models\Voice;

use App\Enums\Status;
use App\Filters\SmsKimlik\SmsKimlikFilter;
use App\Models\AbstractModel;
use App\Models\Customer\Musteri;
use App\Models\MaskableTrait;
use App\Models\SmsKimlik\SmsKimlik;
use App\Models\WebUser\WebUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use function PHPUnit\Framework\isNull;

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

    protected $fillable = [];

    /**
     * @return hasOne
     */
    public function pairedBy(): hasOne
    {
        return $this->hasOne(SmsKimlik::class, 'id', 'eslestiren_id')
                    ->where('durum', '=', Status::ACTIVE);
    }
}
