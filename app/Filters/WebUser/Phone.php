<?php

namespace App\Filters\WebUser;

class Phone
{
    public function apply($query, $value): void
    {
        $query->whereLike('ceptel', $value);
    }
}
