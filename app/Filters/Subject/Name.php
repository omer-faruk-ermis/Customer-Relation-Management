<?php

namespace App\Filters\Subject;

class Name
{
    public function apply($query, $value): void
    {
        $query->whereLike('name', $value);
    }
}
