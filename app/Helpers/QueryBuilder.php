<?php

namespace App\Helpers;

use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Support\Facades\DB;

class QueryBuilder
{
    /**
     * @param string $column
     * @param string $collation
     *
     * @return Expression
     */
    public static function collate(string $column, string $collation = 'SQL_Latin1_General_CP1254_CI_AS'): Expression
    {
        return DB::raw("$column COLLATE $collation");
    }
}
