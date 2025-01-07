<?php

namespace CodeSourceStudio\LaravelPermission\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelPermissionServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishesMigrations([
            __DIR__.'/../../database/migrations' => database_path('migrations'),
        ], 'permissions-migrations');

        $this->publishes([__DIR__.'/../../config/permission.php' => config_path('permissions.php')], 'permissions-config');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/permission.php',
            'permission'
        );
    }
}
