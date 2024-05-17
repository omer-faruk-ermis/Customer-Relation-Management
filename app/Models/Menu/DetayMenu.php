<?php

namespace App\Models\Menu;

use App\Models\AbstractModel;
use App\Models\SmsKimlik\SmsKimlik;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Str;

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
                    ->with('members');
    }

    /**
     * @return hasManyThrough
     */
    public function members(): hasManyThrough
    {
        return $this->hasManyThrough(
            SmsKimlik::class,
            DetayMenuUser::class,
            'menu_id',
            'id',
            'id',
            'userid'
        );
    }
}
