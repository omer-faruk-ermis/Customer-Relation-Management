<?php

namespace App\Filters\SmsKimlikLog;

use App\Models\Log\SebepLog;

class Description
{
    public function apply($query, $value): void
    {
        $sebepLog = SebepLog::getModel();

        $query->where($sebepLog->qualifyColumn('aciklama'), 'LIKE', '%' . $value . '%');
    }
}
