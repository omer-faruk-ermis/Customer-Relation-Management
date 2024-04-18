<?php

namespace App\Models\SmsKimlik;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SmsKimlikBirim
 *
 * @package App\Models
 */
class SmsKimlikBirim extends Model
{
    protected $table = 'kaynaksms.dbo.sms_kimlik_birim';

    /**
     * Get a new instance of the model.
     *
     * @return static
     */
    public static function getModel(): static
    {
        return new static();
    }
}
