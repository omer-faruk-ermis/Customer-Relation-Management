<?php

namespace App\Filters\Module;

class Search
{
    public function apply($query, $value): void
    {
        $query->where('name', 'LIKE', '%' . $value . '%');
    }
}
