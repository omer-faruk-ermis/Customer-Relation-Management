<?php

namespace App\Filters\WebUser;

class Phone
{
    public function apply($query, $value): void
    {
        $query->where('ceptel', 'LIKE', '%' . $value . '%');
    }
}
