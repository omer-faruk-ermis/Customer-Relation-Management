<?php

namespace App\Models\Subject;

use App\Models\AbstractModel;

/**
 * Class KonuBilgiKullanimYeri
 *
 * @package App\Models\Subject
 * @version June 25, 2024, 9:25 pm UTC
 *
 * @property int    $id
 * @property string $adi
 * @property int    $durum
 */
class KonuBilgiKullanimYeri extends AbstractModel
{
    protected $table = 'crm.dbo.konu_bilgi_kullanim_yeri';
}
