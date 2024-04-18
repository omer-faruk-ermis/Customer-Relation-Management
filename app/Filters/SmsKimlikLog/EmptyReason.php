<?php

namespace App\Filters\SmsKimlikLog;

use App\Models\Log\SebepLog;

class EmptyReason
{
    public function apply($query, $value): void
    {
        $sebepLog = SebepLog::getModel();

        $query->when($value == 1, function ($query) use ($sebepLog) {
            $query->where($sebepLog->qualifyColumn('sebep_id'), '=', 0);
        });
    }
}
