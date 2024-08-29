<?php

namespace App\Filters\Menu;

class Search
{
    public function apply($query, $value): void
    {
        $query->whereLike('menu', $value);
    }
}
