<?php

namespace App\Filters\WebUser;

class Location
{
    public function apply($query, $value): void
    {
        $query->where('vergidairesi', 'LIKE', '%' . $value . '%');
    }
}
