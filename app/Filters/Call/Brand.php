<?php

namespace App\Filters\Call;

use App\Models\Call\Cagri;
use App\Utils\ArrayUtil;

class Brand
{
    public function apply($query, $value): void
    {
        $cagri = Cagri::getModel();

        $query->whereIn($cagri->qualifyColumn('sube'),  ArrayUtil::castArray($value));
    }
}
