<?php

namespace App\Filters\Reason;

class Type
{
    public function apply($query, $value): void
    {
        $query->where('ust_id', '=', $value);
    }
}
