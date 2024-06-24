<?php

namespace App\Models\Call;

use App\Models\AbstractModel;
use App\Models\MaskableTrait;

/**
 * Class CagriDetay
 *
 * Last record 2017
 *
 * @package App\Models\Call
 * @version July 05, 2024, 0:11 pm UTC
 *
 * @property int    $id
 * @property int    $hat
 * @property string $bas_tar
 * @property string $bit_tar
 * @property int    $ust_id
 * @property int    $durum
 */
class CagriDetay extends AbstractModel
{
    use MaskableTrait;

    protected $table = 'crm.dbo.cagri_detay';

    protected $fillable = [];
}
