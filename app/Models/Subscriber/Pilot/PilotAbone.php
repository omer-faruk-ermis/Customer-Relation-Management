<?php

namespace App\Models\Subscriber\Pilot;

use App\Models\AbstractModel;

/**
 * Class PilotAbone
 *
 * @package App\Models\Subscriber\Pilot
 * @version October 04, 2024, 11:27 am UTC
 *
 * @property int    $id
 * @property int    $pilot_userid
 * @property int    $userid
 * @property int    $durum
 * @property string $pilot_kayittar
 * @property string $pilot_gunceltar
 */
class PilotAbone extends AbstractModel
{
    protected $table = 'kaynaksms_ucretlendirme.dbo.pilot_abone';
}
