<?php

namespace App\Filters\SmsKimlikLog;

class Description
{
    public function apply($query, $value): void
    {
        $query->whereHas('reasonLog', function ($reasonLogQuery) use ($value) {
            $reasonLogQuery->where('aciklama', 'LIKE', '%' . $value . '%');
        });
    }
}
