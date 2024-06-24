<?php

namespace App\Filters\WebUser;

use App\Models\SimCard\SimKart;

class SimCard
{
    public function apply($query, $value): void
    {
        $query->whereHas('simCard', function ($q) use ($value) {
            $q->whereRaw('LEFT(' . SimKart::getModel()->qualifyColumn('ICCID') . ', 18) LIKE ?', ['%' . $value . '%']);
        });
    }
}
