<?php

namespace App\Models\Log;

use App\Models\AbstractModel;
use App\Models\Sebep\Sebepler;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class SebepLog
 *
 * @package App\Models\Log
 * @version April 19, 2024, 2:21 pm UTC
 *
 * @property int           $id
 * @property int           $logid
 * @property int           $userid
 * @property int           $sebep_id
 * @property string        $aciklama
 * @property int           $kayit_id
 * @property string        $kayit_ip
 * @property string        $kayit_tar
 * @property int           $gorusme_id
 *
 * @property-read Sebepler $reason
 *
 * @method static Builder|SebepLog filter(array $filters = [])
 */
class SebepLog extends AbstractModel
{
    protected $table = 'crm.dbo.sebep_log';

    protected $fillable = [
        'sebep_id',
        'logid',
        'aciklama',
        'kayit_id',
        'kayit_ip',
        'kayit_tar'
    ];

    /**
     * @return hasOne
     */
    public function reason(): hasOne
    {
        return $this->hasOne(Sebepler::class, 'id', 'sebep_id');
    }
}
