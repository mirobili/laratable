<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindServices();
    }

    /**
     * Bind all services to their implementations.
     *
     * @return void
     */
    private function bindServices()
    {
        $services = [
            'Company',
            'Venue',
            'Table',
            'Menu',
            'MenuSection',
            'MenuItem',
            'Product',
            'Order',
            'Employee',
            'ActionLog',
            'Notification',
        ];

        foreach ($services as $service) {
            $this->app->bind(
                "App\\Services\\{$service}Service",
                "App\\Services\\{$service}Service"
            );
        }
    }
}
