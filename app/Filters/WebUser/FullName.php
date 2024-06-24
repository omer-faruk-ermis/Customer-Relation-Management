<?php

namespace App\Filters\WebUser;

class FullName
{
    public function apply($query, $value): void
    {
        $query->whereRaw("CONCAT(ad, ' ', soyad) LIKE ?", ['%' . $value . '%']);
    }
}
