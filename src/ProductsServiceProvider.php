<?php

namespace Hosein\Products;

use Illuminate\Support\ServiceProvider;

class ProductsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/Views', 'ProductView');
        $this->publishes([
            __DIR__.'/Views' => resource_path('views/vendor/ProductView'),
        ],"productview");
        $this->publishes([
            __DIR__.'/Migrations' => database_path('/migrations')
        ], 'productmigrations');
        $this->loadMigrationsFrom(__DIR__.'/Migrations');
    }
}
