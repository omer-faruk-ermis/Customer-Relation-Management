<?php

namespace App\Models\WebPortal;

use App\Models\AbstractModel;

/**
 * Class WebPortalYetki
 *
 * @package App\Models\WebPortal
 * @version April 29, 2024, 2:20 pm UTC
 *
 * @property int    $id
 * @property int    $yetki_id
 * @property int    $userid
 * @property bool   $usermi
 * @property bool   $durum
 * @property string $tarih
 * @property int    $ekuserid
 */
class WebPortalYetkiIzin extends AbstractModel
{
    protected $table = 'kaynaksms_diger.dbo.webportal_yetki_izin';
}
