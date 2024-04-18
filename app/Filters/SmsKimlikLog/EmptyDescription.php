<?php

namespace App\Filters\SmsKimlikLog;

use App\Models\Log\SebepLog;

class EmptyDescription
{
    public function apply($query, $value): void
    {
        $sebepLog = SebepLog::getModel();

        $query->when($value == 1, function ($query) use ($sebepLog) {
            $query->whereNull($sebepLog->qualifyColumn('aciklama'));
        });
    }
}
