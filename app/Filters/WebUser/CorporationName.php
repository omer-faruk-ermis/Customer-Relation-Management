<?php

namespace App\Filters\WebUser;

class CorporationName
{
    public function apply($query, $value): void
    {
        $query->whereLike('kurumadi', $value);
    }
}
