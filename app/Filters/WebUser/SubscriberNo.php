<?php

namespace App\Filters\WebUser;

class SubscriberNo
{
    public function apply($query, $value): void
    {
        $query->where('telno', 'LIKE', '%' . $value . '%');
    }
}
