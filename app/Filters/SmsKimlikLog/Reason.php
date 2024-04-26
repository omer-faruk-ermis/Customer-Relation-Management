<?php

namespace App\Filters\SmsKimlikLog;

class Reason
{
    public function apply($query, $value): void
    {
        $query->whereHas('reasonLog', function ($reasonLogQuery) use ($value) {
            $reasonLogQuery->where('sebep_id', '=', $value);
        });
    }
}
