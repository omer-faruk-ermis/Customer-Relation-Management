<?php

namespace App\Models\SimCard;

use App\Models\AbstractModel;

/**
 * Class SimKart
 *
 * @package App\Models\SimCard
 * @version June 20, 2024, 10:54 pm UTC
 *
 * @property int    $id
 * @property int    $ICCID
 * @property string $PIN1
 * @property string $PIN2
 * @property string $PUK1
 * @property string $PUK2
 */
class SimKart extends AbstractModel
{
    protected $table = 'kaynaksms.dbo.sim_kart';
}
