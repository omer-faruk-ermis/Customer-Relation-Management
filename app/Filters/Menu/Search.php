<?php

namespace App\Filters\Menu;

class Search
{
    public function apply($query, $value): void
    {
        $query->where(function ($query) use ($value) {
            $query->where('menu', 'LIKE', '%' . $value . '%')
                  ->orWhereHas('pages', function ($q) use ($value) {
                      $q->where('url', 'LIKE', '%' . $value . '%')
                        ->orWhere('adi', 'LIKE', '%' . $value . '%');
                  });
        });
    }
}
