<?php

namespace App\Filters\SmsKimlikLog;

use App\Models\Log\SmsKimlikLog;

class Agent
{
    public function apply($query, $value): void
    {
        $smsKimlikLog = SmsKimlikLog::getModel();

        $query->where($smsKimlikLog->qualifyColumn('smskimlik'), '=', $value);
    }
}
