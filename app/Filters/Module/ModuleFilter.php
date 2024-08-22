<?php

namespace App\Filters\Module;

use App\Filters\AbstractFilter;

class ModuleFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'search' => Search::class,
        ];
    }
}
