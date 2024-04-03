<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ExternalApiService;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ExternalApiService::class, function ($app) {
            return new ExternalApiService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Passport::routes();
    }
}
