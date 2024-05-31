<?php

namespace App\Models\Menu;

use App\Models\AbstractModel;
use App\Models\Url\UrlTanim;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class MenuTanim
 *
 * @package App\Models\Menu
 * @version April 26, 2024, 0:01 pm UTC
 *
 * @property int           $id
 * @property string        $menu
 * @property int           $sira
 * @property bool          $durum
 *
 * @property-read UrlTanim $pages
 */
class MenuTanim extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.menutanim';

    /**
     * @return hasMany
     */
    public function pages(): hasMany
    {
        return $this->hasMany(UrlTanim::class, 'ust_id', 'id')
                    ->with(['members', 'recorder']);
    }
}
