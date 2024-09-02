<?php

namespace App\Filters\WebPortal;

use App\Filters\AbstractFilter;

class WebPortalYetkiFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'search' => Search::class,
        ];
    }
}
