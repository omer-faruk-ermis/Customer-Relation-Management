<?php

namespace App\Filters\Menu;

class Search
{
    public function apply($query, $value): void
    {
        $query->where('menu', 'LIKE', '%' . $value . '%');
    }
}
