<?php

namespace App\Filters\WebUser;

class TaxIdentificationNo
{
    public function apply($query, $value): void
    {
        $query->where('verginumarasi', 'LIKE', '%' . $value . '%');
    }
}
