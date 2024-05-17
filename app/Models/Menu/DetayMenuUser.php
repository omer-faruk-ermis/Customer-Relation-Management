<?php

namespace App\Models\Menu;

use App\Models\AbstractModel;

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
}
