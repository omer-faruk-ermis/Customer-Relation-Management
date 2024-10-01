<?php

namespace App\Filters\Reason;

class Description
{
    public function apply($query, $value): void
    {
        $query->whereLike('aciklama', $value);
    }
}
