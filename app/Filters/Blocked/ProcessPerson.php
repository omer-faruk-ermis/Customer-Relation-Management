<?php

namespace App\Filters\Blocked;

class ProcessPerson
{
    public function apply($query, $value): void
    {
        $query->where('kayit_id', $value);
    }
}
