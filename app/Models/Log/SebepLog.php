<?php

namespace App\Models\Log;

use App\Models\AbstractModel;

/**
 * Class SebepLog
 *
 * @package App\Models
 */
class SebepLog extends AbstractModel
{
    protected $table = 'crm.dbo.sebep_log';

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
