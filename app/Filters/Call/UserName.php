<?php

namespace App\Filters\Call;

class UserName
{
    public function apply($query, $value): void
    {
        $query->having('user_name', 'LIKE', '%' . $value . '%');
    }
}
