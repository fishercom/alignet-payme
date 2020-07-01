<?php

namespace LaravelPaymeAlignet\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelPaymeAlignet\LaravelPayme;

class LaravelPaymeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__ . '/../config/laravel-payme.php' => config_path('laravel-payme.php'),
            ], 'laravel.payme.config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-payme.php', 'laravel-payme');

        $this->app->bind('laravel.payme.alignet', LaravelPayme::class);
    }
}