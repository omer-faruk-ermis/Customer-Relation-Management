<?php

namespace App\Models\SmsKimlik;

use App\Models\AbstractModel;

/**
 * Class SmsKimlikBirim
 *
 * @package App\Models
 */
class SmsKimlikBirim extends AbstractModel
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
