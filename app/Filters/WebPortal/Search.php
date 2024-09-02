<?php

namespace App\Filters\WebPortal;

class Search
{
    public function apply($query, $value): void
    {
        $query->whereLike('aciklama', $value);
    }
}
