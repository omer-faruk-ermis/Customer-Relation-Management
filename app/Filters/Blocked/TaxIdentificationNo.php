<?php

namespace App\Filters\Blocked;

class TaxIdentificationNo
{
    public function apply($query, $value): void
    {
        $query->whereLike('vergino', $value);
    }
}
