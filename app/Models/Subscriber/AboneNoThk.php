<?php

namespace App\Models\Subscriber;

use App\Models\AbstractModel;

/**
 * Class AboneNoThk
 *
 * @package App\Models\Subscriber
 * @version July 11, 2024, 9:29 am UTC
 *
 * @property int $id
 * @property int $telno
 * @property int $durum
 * @property int $userid
 * @property int $op_kodu
 * @property int $ananumara
 * @property int $numara_tipi
 * @property int $grup_sirasi
 */
class AboneNoThk extends AbstractModel
{
    protected $table = 'kaynaksms.dbo.abone_no_thk';
}
