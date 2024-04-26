<?php

namespace App\Models\Sebep;

use App\Models\AbstractModel;

/**
 * Class SebepIstenecekler
 *
 * @package App\Models\Sebep
 * @version April 19, 2024, 2:11 pm UTC
 *
 * @property int    $id
 * @property string $tablo_adi
 * @property string $alan_adi
 * @property string $ifade
 */
class SebepIstenecekler extends AbstractModel
{
    protected $table = 'crm.dbo.sebep_istenecekler';
}
