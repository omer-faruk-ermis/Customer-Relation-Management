<?php

namespace App\Filters\WebUser;

class SubscriberNo
{
    public function apply($query, $value): void
    {
        $query->whereLike('telno', $value);
    }
}
