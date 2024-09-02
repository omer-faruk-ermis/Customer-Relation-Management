<?php

namespace App\Filters\StaffGroup;

class Search
{
    public function apply($query, $value): void
    {
        $query->whereLike('grup_adi', $value);
    }
}
