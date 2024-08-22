<?php

namespace App\Models\Menu;

use App\Filters\Menu\MenuDefinitionFilter;
use App\Models\AbstractModel;
use App\Models\Module\Module;
use App\Models\Url\UrlTanim;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
 * @property string        $path
 * @property string        $color
 * @property string        $icon
 * @property int           $module_id
 *
 * @property-read UrlTanim $pages
 *
 * @method static Builder|MenuTanim filter(array $filters = [])
 */
class MenuTanim extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.menutanim';

    protected $fillable = [
        'menu',
        'sira',
        'durum',
        'path',
        'color',
        'icon',
        'module_id'
    ];

    /**
     * @return hasMany
     */
    public function pages(): hasMany
    {
        return $this->hasMany(UrlTanim::class, 'ust_id', 'id')
                    ->with(['authorizations', 'recorder'])
                    ->active();
    }

    /**
     * @return hasOne
     */
    public function module(): hasOne
    {
        return $this->hasOne(Module::class, 'id', 'module_id')
                    ->active();
    }

    /**
     * @param $filters
     *
     * @return MenuDefinitionFilter
     */
    protected function filter($filters): MenuDefinitionFilter
    {
        return new MenuDefinitionFilter($filters);
    }
}
