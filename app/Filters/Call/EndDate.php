<?php

namespace App\Filters\Call;

use Illuminate\Support\Carbon;

class EndDate
{
    public function apply($query, $value): void
    {
        $query->whereDate('bit_tar', '<=', Carbon::parse($value));
    }
}
