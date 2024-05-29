<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*if (config('app.debug')) {
            DB::listen(function ($query) {
                Log::channel('sql')->debug($query->sql, $query->bindings, $query->time);
            });
        }*/
        /*if(config('app.env') === 'local') {
            $this->app['request']->server->set('HTTPS', true);
        }*/
    }
}
