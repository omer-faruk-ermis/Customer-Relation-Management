<?php

namespace App\Filters\Subject;

class Name
{
    public function apply($query, $value): void
    {
        $query->whereHas('subSubject', function ($qq) use ($value) {
            $qq->whereLike('ad', $value);
        });
    }
}
