<?php

namespace App\Filters\Blocked;

use App\Filters\AbstractFilter;

class BlockedTaxIdentificationNoFilter extends AbstractFilter
{
    protected function defineFilters(): array
    {
        return [
            'tax_identfication_no' => TaxIdentificationNo::class,
            'start_date'           => StartDate::class,
            'end_date'             => EndDate::class,
            'process_person'       => ProcessPerson::class,
        ];
    }
}
