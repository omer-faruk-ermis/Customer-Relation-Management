<?php

namespace App\Filters\WebUser;

class UserName
{
    public function apply($query, $value): void
    {
        $query->where('name', 'LIKE', '%' . $value . '%');
    }
}
