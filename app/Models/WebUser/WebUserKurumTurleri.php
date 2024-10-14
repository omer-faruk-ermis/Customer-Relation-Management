<?php

namespace App\Models\WebUser;

use App\Models\AbstractModel;

/**
 * Class WebUserKurumTurleri
 *
 * @package App\Models\WebUser
 * @version October 14, 2024, 10:32 am UTC
 *
 * @property int    $id
 * @property string $tur_isim
 */
class WebUserKurumTurleri extends AbstractModel
{
    protected $table = 'kaynaksms.dbo.webuser_kurum_turleri';
}
