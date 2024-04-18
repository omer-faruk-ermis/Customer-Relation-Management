<?php

namespace App\Filters\SmsKimlikLog;

use Illuminate\Support\Carbon;

class MinDate
{
    public function apply($query, $value): void
    {
        $query->whereDate('tarih', '>=', Carbon::parse($value));
    }
}
