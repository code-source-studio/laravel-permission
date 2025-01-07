<?php

declare(strict_types=1);

namespace CodeSourceStudio\LaravelPermission\Providers;

use CodeSourceStudio\LaravelPermission\Commands\CreateGroupCommand;
use CodeSourceStudio\LaravelPermission\Commands\CreatePermissionCommand;
use Illuminate\Support\ServiceProvider;

class LaravelPermissionServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerCommands();

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

    private function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreatePermissionCommand::class,
                CreateGroupCommand::class,
            ]);
        }
    }
}
