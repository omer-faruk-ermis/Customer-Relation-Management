<?php

namespace App\Filters\QuestionAnswer;

use Illuminate\Support\Carbon;

class MinDate
{
    public function apply($query, $value): void
    {
        $query->whereDate('kayit_tarih', '>=', Carbon::parse($value));
    }
}
