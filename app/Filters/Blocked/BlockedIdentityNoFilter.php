<?php

namespace App\Filters\Blocked;

use App\Filters\AbstractFilter;

class BlockedIdentityNoFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'identity_no'    => IdentityNo::class,
            'start_date'     => StartDate::class,
            'end_date'       => EndDate::class,
            'process_person' => ProcessPerson::class,
        ];
    }
}
