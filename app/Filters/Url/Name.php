<?php

namespace App\Filters\Url;

class Name
{
    public function apply($query, $value): void
    {
        $query->whereLike('adi', $value);
    }
}
