<?php

namespace App\Filters\WebUser;

class UserType
{
    public function apply($query, $value): void
    {
        $query->where('kullanici_tipi', '=', $value);
    }
}
