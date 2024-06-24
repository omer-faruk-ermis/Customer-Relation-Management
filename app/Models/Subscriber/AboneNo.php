<?php

namespace App\Models\Subscriber;

use App\Models\AbstractModel;

/**
 * Class AboneNo
 *
 * @package App\Models\Subscriber
 * @version July 11, 2024, 9:29 pm UTC
 *
 * @property int    $id
 * @property int    $telno
 * @property int    $durum
 * @property int    $userid
 * @property int    $pr
 * @property int    $pr_alt
 * @property int    $op_kodu
 * @property int    $testno
 * @property int    $tasinmis_no
 * @property int    $orjdurum
 * @property int    $abno_brandCode
 * @property string $abno_brandName
 */
class AboneNo extends AbstractModel
{
    protected $table = 'kaynaksms.dbo.abone_no';
}
