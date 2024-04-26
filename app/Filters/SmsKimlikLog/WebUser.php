<?php

namespace App\Filters\SmsKimlikLog;

class WebUser
{
    public function apply($query, $value): void
    {
        $query->where('userid', '=', $value);
    }
}
