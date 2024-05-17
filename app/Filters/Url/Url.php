<?php

namespace App\Filters\Url;

class Url
{
    public function apply($query, $value): void
    {
        $query->where('url', 'LIKE', '%' . $value . '%');
    }
}
