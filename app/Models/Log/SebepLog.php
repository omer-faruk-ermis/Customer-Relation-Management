<?php

namespace App\Models\Log;

use App\Models\AbstractModel;
use App\Models\Sebep\Sebepler;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class SebepLog
 *
 * @package App\Models
 */
class SebepLog extends AbstractModel
{
    protected $table = 'crm.dbo.sebep_log';

    /**
     * @return hasOne
     */
    public function sebep(): hasOne
    {
        return $this->hasOne(Sebepler::class, 'id', 'sebep_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sebep_id',
        'logid',
        'aciklama',
        'kayit_id',
        'kayit_ip',
        'kayit_tar'
    ];
}
