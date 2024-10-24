<?php

namespace App\Filters\Blocked;

class IdentityNo
{
    public function apply($query, $value): void
    {
        $query->whereLike('kimlikno', $value);
    }
}
