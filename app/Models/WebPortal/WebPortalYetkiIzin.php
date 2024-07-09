<?php

namespace App\Models\WebPortal;

use App\Enums\Status;
use App\Models\AbstractModel;
use App\Models\SmsKimlik\SmsKimlik;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class WebPortalYetkiIzin
 *
 * @package App\Models\WebPortal
 * @version April 29, 2024, 2:20 pm UTC
 *
 * @property int    $id
 * @property int    $yetki_id
 * @property int    $userid
 * @property bool   $usermi
 * @property bool   $durum
 * @property string $tarih
 * @property int    $ekuserid
 */
class WebPortalYetkiIzin extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.webportal_yetki_izin';

    protected $fillable = [
        'yetki_id',
        'userid',
        'usermi',
        'durum',
        'tarih',
        'ekuserid'
    ];

    /**
     * @return hasOne
     */
    public function members(): hasOne
    {
        return $this->hasOne(SmsKimlik::class, 'id', 'userid')
                    ->where('durum', '=', Status::ACTIVE);
    }
}
