<?php

namespace App\Filters\SmsKimlikLog;

use App\Helpers\QueryBuilder;

class LogSubject
{
    public function apply($query, $value): void
    {
        $query->whereHas('reasonWanted', function ($reasonWantedQuery) use ($value) {
            $reasonWantedQuery->where(QueryBuilder::collate('ifade'), 'LIKE', '%' . $value . '%');
        });
    }
}
