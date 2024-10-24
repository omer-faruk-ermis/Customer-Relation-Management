<?php

namespace App\Filters\Blocked;

use App\Filters\AbstractFilter;

class BlockedEmailFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'email'          => Email::class,
            'start_date'     => StartDate::class,
            'end_date'       => EndDate::class,
            'process_person' => ProcessPerson::class,
        ];
    }
}
