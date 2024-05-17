<?php

namespace App\Filters\Url;

use App\Filters\AbstractFilter;
use App\Filters\WebUser\AgreementState;
use App\Filters\WebUser\Location;
use App\Filters\WebUser\UserType;

class UrlDefinitionFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'url'           => Url::class,
            'name'          => Name::class,
        ];
    }
}
