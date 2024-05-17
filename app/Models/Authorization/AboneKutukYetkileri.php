<?php

namespace App\Models\Authorization;

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
 */
class AboneKutukYetkileri extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.abone_kutuk_yetkileri';
}
