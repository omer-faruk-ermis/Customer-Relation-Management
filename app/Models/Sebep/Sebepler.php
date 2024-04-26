<?php

namespace App\Models\Sebep;

use App\Models\AbstractModel;

/**
 * Class Sebepler
 *
 * @package App\Models\Sebep
 * @version April 19, 2024, 2:11 pm UTC
 *
 * @property int    $id
 * @property string $aciklama
 * @property int    $ust_id
 * @property int    $karaliste_seviye
 * @property string $created_at
 * @property string $updated_at
 */
class Sebepler extends AbstractModel
{
    protected $table = 'crm.dbo.sebepler';
}
