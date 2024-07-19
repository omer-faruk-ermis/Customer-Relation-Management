<?php

namespace App\Filters\Subject;

use App\Filters\AbstractFilter;

class SubjectInformationFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'name' => Name::class,
        ];
    }
}
