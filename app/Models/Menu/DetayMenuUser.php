<?php

namespace App\Models\Menu;

use App\Enums\Status;
use App\Models\AbstractModel;
use App\Models\SmsKimlik\SmsKimlik;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class DDetayMenuUser
 *
 * @package App\Models\Menu
 * @version April 26, 2024, 0:01 pm UTC
 *
 * @property int    $id
 * @property int    $menu_id
 * @property int    $userid
 * @property string $kayit_tar
 * @property int    $kayit_id
 * @property string $kayit_ip
 * @property bool   $durum
 */
class DetayMenuUser extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.detay_menu_user';

    protected $fillable = [
        'menu_id',
        'userid',
        'kayit_tar',
        'kayit_id',
        'kayit_ip',
        'durum'
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
