<?php

namespace App\Models\Log;

use App\Filters\SmsKimlikLog\SmsKimlikLogFilter;
use App\Models\AbstractModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class SmsKimlikLog
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $alanadi
 * @property string $tabloadi
 * @property string $sebepLog
 *
 */
class SmsKimlikLog extends AbstractModel
{
    protected $table = 'kaynaksms.dbo.sms_kimlik_log';

    /**
     * @return HasMany
     */
    public function sebepLog(): HasMany
    {
        return $this->hasMany(SebepLog::class, 'logid', 'id');
    }

    /**
     * @param $filters
     * @return SmsKimlikLogFilter
     */
    protected function filter($filters): SmsKimlikLogFilter
    {
        return new SmsKimlikLogFilter($filters);
    }
}
