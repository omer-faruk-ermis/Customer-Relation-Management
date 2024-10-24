<?php

namespace App\Filters\Blocked;

class Email
{
    public function apply($query, $value): void
    {
        $query->whereLike('mail', $value);
    }
}
