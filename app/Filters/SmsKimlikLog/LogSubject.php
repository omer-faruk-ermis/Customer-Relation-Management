<?php

namespace App\Filters\SmsKimlikLog;

class LogSubject
{
    public function apply($query, $value): void
    {
        $query->whereHas('reasonWanted', function ($reasonWantedQuery) use ($value) {
            $reasonWantedQuery->where('ifade', 'LIKE', '%' . $value . '%');
        });
    }
}
