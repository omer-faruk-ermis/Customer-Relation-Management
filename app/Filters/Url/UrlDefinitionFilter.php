<?php

namespace App\Filters\Url;

use App\Filters\AbstractFilter;

class UrlDefinitionFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'url'    => Url::class,
            'name'   => Name::class,
            'search' => Search::class,
        ];
    }
}
