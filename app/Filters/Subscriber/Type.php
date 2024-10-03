<?php

namespace App\Filters\Subscriber;

class Type
{
    public function apply($query, $value): void
    {
        $query->where('tip', $value);
    }
}
