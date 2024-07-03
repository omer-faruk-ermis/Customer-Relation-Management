<?php

namespace App\Filters\Url;

class Search
{
    public function apply($query, $value): void
    {
        $query->orWhere('url', 'LIKE', '%' . $value . '%')
              ->orWhere('adi', 'LIKE', '%' . $value . '%');
    }
}
