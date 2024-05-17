<?php

namespace App\Filters\WebUser;

class AgreementState
{
    public function apply($query, $value): void
    {
        $query->where('sozlesme', '=', $value);
    }
}
