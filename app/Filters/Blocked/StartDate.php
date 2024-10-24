<?php

namespace App\Filters\Blocked;

use Illuminate\Support\Carbon;

class StartDate
{
    public function apply($query, $value): void
    {
        $query->whereDate('kayit_tar', '>=', Carbon::parse($value));
    }
}
