<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register custom service providers
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(ServiceServiceProvider::class);
        
        // Set Sanctum configuration
        config(['sanctum.expiration' => config('sanctum.expiration', 60 * 24 * 30)]); // 30 days
        
        // Set tokenable model
        config(['sanctum.tokenable_model' => \App\Models\Employee::class]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set the default string length for migrations
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);
    }
}
