<?php

namespace App\Filters\Reason;

use App\Filters\AbstractFilter;

class ReasonFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'type'        => Type::class,
            'description' => Description::class,
            'operation'   => Operation::class,
        ];
    }
}
