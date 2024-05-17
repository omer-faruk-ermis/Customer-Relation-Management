<?php

namespace App\Models\WebPortal;

use App\Models\AbstractModel;
use Illuminate\Support\Carbon;

/**
 * Class WebPortalYetki
 *
 * @package App\Models\WebPortal
 * @version April 26, 2024, 0:05 pm UTC
 *
 * @property int    $id
 * @property string $aciklama
 * @property bool   $durum
 * @property Carbon $tarih
 * @property string $tanim
 * @property string $yetki_detay
 * @property int    $menu_id
 * @property int    $tip
 */
class WebPortalYetki extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.webportal_yetki'; //Authorization - Yetkilendirme
}
