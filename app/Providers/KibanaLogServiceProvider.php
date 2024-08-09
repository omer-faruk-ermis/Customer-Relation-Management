<?php

namespace App\Providers;

use App\Models\Log\KibanaLog;
use Illuminate\Support\ServiceProvider;

class KibanaLogServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(KibanaLog::class, function ($app) {
            return new KibanaLog();
        });
    }

    public function boot()
    {
        // Boot logic if needed
    }
}
