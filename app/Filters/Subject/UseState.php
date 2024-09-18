<?php

namespace App\Filters\Subject;

class UseState
{
    public function apply($query, $value): void
    {
        $query->where('kullanim_durum', '=', $value);
    }
}
