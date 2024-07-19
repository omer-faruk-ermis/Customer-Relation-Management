<?php

namespace App\Models\Subject;

use App\Models\AbstractModel;

/**
 * Class KonuBilgiTip
 *
 * @package App\Models\Subject
 * @version June 25, 2024, 11:29 pm UTC
 *
 * @property int    $tipid
 * @property string $color
 */
class KonuBilgiTip extends AbstractModel
{
    protected $table = 'crm.dbo.konu_bilgi_tip';
}
