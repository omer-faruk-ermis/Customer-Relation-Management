<?php

namespace App\Filters\Call;


use App\Utils\ArrayUtil;

class CallDirection
{
    public function apply($query, $value): void
    {
        $query->whereIn('cagri_yonu', ArrayUtil::castArray($value));
    }
}
