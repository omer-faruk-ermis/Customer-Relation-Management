<?php

namespace App\Filters\WebUser;

class IdentityNo
{
    public function apply($query, $value): void
    {
        $query->whereLike('tckimlik', $value);
    }
}
