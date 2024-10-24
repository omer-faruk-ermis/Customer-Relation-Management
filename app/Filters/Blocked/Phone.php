<?php

namespace App\Filters\Blocked;

class Phone
{
    public function apply($query, $value): void
    {
        $query->whereLike('telno', $value);
    }
}
