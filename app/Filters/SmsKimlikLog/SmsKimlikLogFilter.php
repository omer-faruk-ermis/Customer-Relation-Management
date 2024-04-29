<?php

namespace App\Filters\SmsKimlikLog;

use App\Filters\AbstractFilter;

class SmsKimlikLogFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'max_date'          => MaxDate::class,
            'min_date'          => MinDate::class,
            'process_person'    => ProcessPerson::class,
            //'log_subject'       => LogSubject::class,
            'web_user'          => WebUser::class,
            'agent'             => Agent::class,
            'empty_description' => EmptyDescription::class,
            'description'       => Description::class,
            'empty_reason'      => EmptyReason::class,
            'reason'            => Reason::class,
        ];
    }
}
