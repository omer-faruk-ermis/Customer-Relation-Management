<?php

namespace App\Filters\Module;

class Search
{
    public function apply($query, $value): void
    {
        $query->whereLike('name', $value);
    }
}
