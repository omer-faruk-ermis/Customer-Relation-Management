<?php

namespace App\Filters\Call;

use App\Filters\AbstractFilter;

class CallFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'call_direction' => CallDirection::class,
            'call_phone'     => CallPhone::class,
            'start_date'     => StartDate::class,
            'end_date'       => EndDate::class,
            'brand'          => Brand::class,
            'user_type'      => UserType::class,
          //  'user_name'      => UserName::class,
            // 'user_phone'     => UserPhone::class,
        ];
    }
}
