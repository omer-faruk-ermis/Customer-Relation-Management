<?php

namespace App\Filters\Reason;

class Operation
{
    public function apply($query, $value): void
    {
        $query->whereHas('reasonWanted', function ($qq) use ($value) {
            $qq->whereLike('ifade', $value);
        });
    }
}
