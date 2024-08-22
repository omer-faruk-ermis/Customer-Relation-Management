<?php

namespace App\Models\Module;

use App\Filters\Module\ModuleFilter;
use App\Models\AbstractModel;
use App\Models\Menu\MenuTanim;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Modules
 *
 * @package App\Models\Module
 * @version August 19, 2024, 10:49 am UTC
 *
 * @property int            $id
 * @property string         $name
 * @property string         $panel
 * @property int            $durum
 * @property string         $path
 * @property string         $color
 * @property string         $icon
 *
 * @property-read MenuTanim $menu
 *
 * @method static Builder|Module filter(array $filters = [])
 */
class Module extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.modules';

    protected $fillable = [
        'name',
        'panel',
        'durum',
        'path',
        'color',
        'icon',
    ];

    /**
     * @return hasOne
     */
    public function menu(): hasOne
    {
        return $this->hasOne(MenuTanim::class, 'module_id', 'id')
                    ->active();
    }

    /**
     * @param $filters
     *
     * @return ModuleFilter
     */
    protected function filter($filters): ModuleFilter
    {
        return new ModuleFilter($filters);
    }
}
