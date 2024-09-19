<?php

namespace App\Filters\Subject;

use App\Filters\AbstractFilter;

class SubjectInformationFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'name'          => Name::class,
            'use_state'     => UseState::class,
            'user_type_ids' => UserType::class,
        ];
    }
}
