<?php

namespace App\Filters\SmsKimlikLog;

use App\Enums\NumericalConstant;

class EmptyDescription
{
    public function apply($query, $value): void
    {
        $query->when($value == NumericalConstant::TRUE, function ($query) use ($value) {
            $query->whereHas('reasonLog', function ($reasonLogQuery) use ($value) {
                $reasonLogQuery->whereNull('aciklama');
            });
        });
    }
}
