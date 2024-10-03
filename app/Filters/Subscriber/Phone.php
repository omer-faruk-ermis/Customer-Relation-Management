<?php

namespace App\Filters\Subscriber;

class Phone
{
    public function apply($query, $value): void
    {
        $query->whereHas('webUser', function ($qq) use ($value) {
            $qq->where('ceptel', $value);
        });
    }
}
