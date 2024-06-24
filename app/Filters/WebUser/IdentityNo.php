<?php

namespace App\Filters\WebUser;

class IdentityNo
{
    public function apply($query, $value): void
    {
        $query->where('tckimlik', 'LIKE', '%' . $value . '%');
    }
}
