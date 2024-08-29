<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait DatabaseTrait
 *
 * @package App\Models
 */
trait DatabaseTrait
{
    /**
     * @param string   $column
     * @param string   $value
     * @param Builder  $query
     *
     * @return Builder
     */
    public static function scopeWhereLike(Builder $query, string $column, string $value): Builder
    {
        return $query->where($column, 'LIKE', '%' . $value . '%');
    }
}
