<?php

namespace App\Models\Menu;

use App\Models\AbstractModel;
use App\Models\SmsKimlik\SmsKimlik;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class DetayMenu
 *
 * @package App\Models\Menu
 * @version April 26, 2024, 0:01 pm UTC
 *
 * @property int            $id
 * @property string         $menu_adi
 * @property string         $menu_url
 * @property string         $kayit_tar
 * @property string         $kayit_ip
 * @property int            $kayit_id
 * @property bool           $durum
 * @property int            $sira
 * @property int            $parentid
 *
 * @property-read DetayMenu $pages
 * @property-read SmsKimlik $members
 * @property-read DetayMenu $menu
 */
class DetayMenu extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.detay_menu';

    /**
     * @return hasMany
     */
    public function pages(): hasMany
    {
        return $this->hasMany(DetayMenu::class, 'parentid', 'id')
                    ->active();
    }

    /**
     * @return hasOne
     */
    public function menu(): hasOne
    {
        return $this->hasOne(DetayMenu::class, 'id', 'parentid')
                    ->active();
    }

    /**
     * @return hasMany
     */
    public function detail(): hasMany
    {
        return $this->hasMany(DetayMenuUser::class, 'menu_id', 'id')
                    ->active();
    }
}
