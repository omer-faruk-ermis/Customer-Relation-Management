<?php

namespace App\Filters\StaffGroup;

use App\Filters\AbstractFilter;

class StaffGroupFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'search' => Search::class,
        ];
    }
}
