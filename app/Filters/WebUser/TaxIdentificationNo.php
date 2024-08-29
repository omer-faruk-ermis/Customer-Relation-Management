<?php

namespace App\Filters\WebUser;

class TaxIdentificationNo
{
    public function apply($query, $value): void
    {
        $query->whereLike('verginumarasi', $value);
    }
}
