<?php

namespace App\Filters\Menu;

use App\Filters\AbstractFilter;

class MenuDefinitionFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'search' => Search::class,
        ];
    }
}
