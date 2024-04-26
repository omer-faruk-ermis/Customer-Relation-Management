<?php

namespace App\Models\Sebep;

use App\Models\AbstractModel;

/**
 * Class SebepAlanAciklama
 *
 * @package App\Models\Sebep
 * @version April 19, 2024, 2:11 pm UTC
 *
 * @property int    $id
 * @property string $tablo_adi
 * @property string $alan_adi
 * @property bool   $deger
 * @property string $aciklama
 * @property string $sql_cumle
 * @property bool   $tur
 */
class SebepAlanAciklama extends AbstractModel
{
    protected $table = 'crm.dbo.sebep_alan_aciklama';
}
