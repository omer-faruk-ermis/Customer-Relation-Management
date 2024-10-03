<?php

namespace App\Filters\Subscriber;

class SubscriberNo
{
    public function apply($query, $value): void
    {
        $query->whereHas('webUser', function ($q) use ($value) {
            $q->whereHas('subscriberNo', function ($qq) use ($value) {
                $qq->where('telno', $value);
            });
        });
    }
}
