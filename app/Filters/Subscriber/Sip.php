<?php

namespace App\Filters\Subscriber;

class Sip
{
    public function apply($query, $value): void
    {
        $query->where('dahili', $value);
    }
}
