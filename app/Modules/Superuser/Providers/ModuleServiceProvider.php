<?php

namespace App\Modules\Superuser\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../Resources/Lang', 'superuser');
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'superuser');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations', 'superuser');
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
