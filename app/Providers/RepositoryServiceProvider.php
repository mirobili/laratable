<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind repositories
        $this->bindRepositories();
    }

    /**
     * Bind all repository interfaces to their implementations.
     *
     * @return void
     */
    private function bindRepositories()
    {
        $repositories = [
            // Company
            'Company' => [],
            // Venue
            'Venue' => [],
            // Table
            'Table' => [],
            // Menu
            'Menu' => [],
            // MenuSection
            'MenuSection' => [],
            // MenuItem
            'MenuItem' => [],
            // Product
            'Product' => [],
            // Order
            'Order' => [],
            // OrderItem
            'OrderItem' => [],
            // Employee
            'Employee' => [],
            // ActionLog
            'ActionLog' => [],
            // Notification
            'Notification' => [],
        ];

        foreach ($repositories as $name => $options) {
            $this->app->bind(
                "App\\Repositories\\Contracts\\{$name}RepositoryInterface",
                "App\\Repositories\\Eloquent\\{$name}Repository"
            );
        }
    }
}
