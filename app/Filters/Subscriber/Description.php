<?php

namespace App\Filters\Subscriber;

class Description
{
    public function apply($query, $value): void
    {
        $query->whereLike('description', $value);
    }
}
