<?php

namespace App\Models\Sebep;

use App\Filters\Reason\ReasonFilter;
use App\Models\AbstractModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Sebepler
 *
 * @package App\Models\Sebep
 * @version April 19, 2024, 2:11 pm UTC
 *
 * @property int                    $id
 * @property string                 $aciklama
 * @property int                    $ust_id
 * @property int                    $karaliste_seviye
 * @property string                 $created_at
 * @property string                 $updated_at
 *
 * @property-read SebepIstenecekler $reasonWanted
 *
 * @method static Builder|Sebepler filter(array $filters = [])
 */
class Sebepler extends AbstractModel
{
    protected $table = 'crm.dbo.sebepler';

    protected $fillable = [
        'aciklama',
        'ust_id'
    ];

    /**
     * @return hasOne
     */
    public function reasonWanted(): hasOne
    {
        return $this->hasOne(SebepIstenecekler::class, 'id', 'ust_id');
    }

    /**
     * @param $filters
     *
     * @return ReasonFilter
     */
    protected function filter($filters): ReasonFilter
    {
        return new ReasonFilter($filters);
    }
}
