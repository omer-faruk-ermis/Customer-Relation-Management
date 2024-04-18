<?php

namespace App\Filters\SmsKimlikLog;

use App\Models\Sebep\SebepIstenecekler;

class LogSubject
{
    public function apply($query, $value): void
    {
        $sebepIstenecekler = SebepIstenecekler::getModel();

        $query->where($sebepIstenecekler->qualifyColumn('ifade'), 'LIKE', '%' . $value . '%');
    }
}
