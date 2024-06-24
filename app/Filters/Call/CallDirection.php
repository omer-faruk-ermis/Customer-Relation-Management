<?php

namespace App\Filters\Call;


class CallDirection
{
    public function apply($query, $value): void
    {
        $query->where('cagri_yonu', '=', $value);
    }
}
