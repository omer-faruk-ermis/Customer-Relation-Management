<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait StatusTrait
 *
 * @package App\Models
 */
trait StatusTrait
{

    /**
     * @param Builder  $query
     * @param array    $statuses
     *
     * @return Builder
     */
    public function scopeStatuses(Builder $query, array $statuses = [Status::ACTIVE]): Builder
    {
        return $query->whereIn('durum', $statuses);
    }

    /**
     * @param Builder  $query
     *
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('durum', Status::ACTIVE);
    }

    /**
     * @param Builder  $query
     *
     * @return Builder
     */
    public function scopePassive(Builder $query): Builder
    {
        return $query->where('durum', Status::PASSIVE);
    }
}
