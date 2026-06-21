<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;

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
        
        // Register Order observer for bonus calculation
        \App\Models\Order::observe(\App\Observers\OrderObserver::class);
        
        // Register webhook middleware alias (currently not needed based on courier docs)
        // Route::aliasMiddleware('webhook.verify', \App\Http\Middleware\VerifyWebhookSignature::class);
    }
}
