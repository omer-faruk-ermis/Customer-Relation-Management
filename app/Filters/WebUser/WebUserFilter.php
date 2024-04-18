<?php

namespace App\Filters\WebUser;

use App\Filters\AbstractFilter;

class WebUserFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'location'        => Location::class,
            'user_type'       => UserType::class,
            'agreement_state' => AgreementState::class
        ];
    }
}
