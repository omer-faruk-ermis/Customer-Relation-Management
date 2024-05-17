<?php

namespace App\Filters\Url;

class Name
{
    public function apply($query, $value): void
    {
        $query->where('adi', 'LIKE', '%' . $value . '%');
    }
}
