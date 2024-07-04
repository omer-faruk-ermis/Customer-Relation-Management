<?php

namespace App\Models\Authorization;

use App\Enums\Authorization\AuthorizationTypeTrName;
use App\Models\AbstractModel;

/**
 * Class AboneKutukYetkileri
 *
 * @package App\Models\Authorization
 * @version April 29, 2024, 2:05 pm UTC
 *
 * @property int    $id
 * @property string $aciklama
 * @property bool   $durum
 *
 * @property string $menu
 */
class AboneKutukYetkileri extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.abone_kutuk_yetkileri';

    protected $appends = ['menu'];

    /**
     * @return string
     */
    public function getMenuAttribute(): string
    {
        return AuthorizationTypeTrName::SUBSCRIBER_BILLET;
    }
}
