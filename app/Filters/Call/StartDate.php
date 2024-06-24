<?php

namespace App\Filters\Call;

use Illuminate\Support\Carbon;

class StartDate
{
    public function apply($query, $value): void
    {
        $query->whereDate('bas_tar', '>=', Carbon::parse($value));
    }
}
