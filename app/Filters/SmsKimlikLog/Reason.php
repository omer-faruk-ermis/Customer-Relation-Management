<?php

namespace App\Filters\SmsKimlikLog;

use App\Models\Log\SebepLog;

class Reason
{
    public function apply($query, $value): void
    {
        $sebepLog = SebepLog::getModel();

        $query->where($sebepLog->qualifyColumn('sebep_id'), '=', $value);
    }
}
