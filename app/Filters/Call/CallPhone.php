<?php

namespace App\Filters\Call;


class CallPhone
{
    public function apply($query, $value): void
    {
        $query->where('cid', '=', $value);
    }
}
