<?php

namespace App\Filters\SmsKimlikLog;

use Illuminate\Support\Carbon;

class MaxDate
{
    public function apply($query, $value): void
    {
        $query->whereDate('tarih', '<=', Carbon::parse($value));
    }
}
