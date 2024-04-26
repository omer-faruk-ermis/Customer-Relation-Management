<?php

namespace App\Filters\SmsKimlikLog;

class ProcessPerson
{
    public function apply($query, $value): void
    {
        $query->whereHas('employee', function ($employeeQuery) use ($value) {
            $employeeQuery->where('id', '=', $value);
        });
    }
}
