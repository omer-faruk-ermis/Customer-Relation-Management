<?php

namespace App\Models\WebUser;

use App\Models\AbstractModel;

/**
 * Class WebUserKullaniciTipleri
 *
 * @package App\Models\WebUser
 * @version June 20, 2024, 10:54 pm UTC
 *
 * @property int    $ktip
 * @property string $kaciklama
 * @property string $kcolor
 * @property string $tip
 */
class WebUserKullaniciTipleri extends AbstractModel
{
    protected $table = 'kaynaksms.dbo.webuser_kullanici_tipleri';
}
