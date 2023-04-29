<?php

namespace GonNl\LaravelStatusEndpoint;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class LaravelStatusEndpointServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerRoutes();
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/routes.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'middleware' => ['api'],
        ];
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-status-endpoint.php', 'laravel-status-endpoint');

    }
}
