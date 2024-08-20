<?php

namespace App\Models\Module;

use App\Models\AbstractModel;
use App\Models\Menu\MenuTanim;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
}
