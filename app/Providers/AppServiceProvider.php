<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ClassificationService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ClassificationService::class, function ($app) {
            return new ClassificationService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
    }
}
