<?php

namespace App\Filters\WebUser;

class CorporationName
{
    public function apply($query, $value): void
    {
        $query->where('kurumadi', 'LIKE', '%' . $value . '%');
    }
}
