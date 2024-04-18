<?php

namespace App\Models;

use App\Enums\DefaultConstant;

/**
 * Trait QualifiableTrait
 *
 * @package App\Models
 */
trait QualifiableTrait
{
    /**
     * Qualify all the columns by the model's table.
     *
     * @return string
     */
    public function qualifyAllColumns(): string
    {
        return self::qualifyColumn(DefaultConstant::ALL_COLUMN);
    }
}
