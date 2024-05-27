<?php

namespace App\Models;

use App\Services\DataMaskingService;

trait MaskableTrait
{
    /**
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();
        static::retrieved(function ($model) {
            $model->attributes = (new DataMaskingService())->halfHide($model->attributesToArray());
        });
    }
}
