<?php

namespace App\Models;

use App\Models\SmsKimlik\SmsKimlik;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Trait RecorderTrait
 *
 * @package App\Models
 */
trait RecorderTrait
{
    /**
     * @return hasOne
     */
    public function recorder(): hasOne
    {
        return $this->hasOne(SmsKimlik::class, 'id', $this->recordField);
    }
}
