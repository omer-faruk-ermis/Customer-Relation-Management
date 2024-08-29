<?php

namespace App\Filters\WebUser;

class UserName
{
    public function apply($query, $value): void
    {
        $query->whereLike('name', $value);
    }
}
