<?php

namespace App\Filters\Subscriber;

class WebUser
{
    public function apply($query, $value): void
    {
        $query->where('userid', $value);
    }
}
