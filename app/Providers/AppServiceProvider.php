<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Services\CartService::class, function ($app) {
            return new \App\Services\CartService($app['session']);
        });
        
        $this->app->alias(\App\Services\CartService::class, 'cart');
        
        // Register UnifiedCourierService
        $this->app->singleton(\App\Services\UnifiedCourierService::class, function ($app) {
            return new \App\Services\UnifiedCourierService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
