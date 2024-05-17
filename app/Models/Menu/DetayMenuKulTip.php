<?php

namespace App\Models\Menu;

use App\Models\AbstractModel;

/**
 * Class DetayMenuKulTip
 *
 * @package App\Models\Menu
 * @version April 26, 2024, 0:01 pm UTC
 *
 * @property int $id
 * @property int $detaymenu_id
 * @property int $kul_tip
 */
class DetayMenuKulTip extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.detay_menu_kultip';
}
