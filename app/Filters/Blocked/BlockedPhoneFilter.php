<?php

namespace App\Filters\Blocked;

use App\Filters\AbstractFilter;

class BlockedPhoneFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'phone'          => Phone::class,
            'start_date'     => StartDate::class,
            'end_date'       => EndDate::class,
            'process_person' => ProcessPerson::class,
        ];
    }
}
