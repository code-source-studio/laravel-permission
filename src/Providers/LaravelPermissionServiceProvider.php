<?php

namespace CodeSourceStudio\LaravelPermission\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelPermissionServiceProvider extends ServiceProvider
{
    public function boot(): void {}

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/permission.php',
            'permission'
        );
    }
}
