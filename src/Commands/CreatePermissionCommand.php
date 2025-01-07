<?php

declare(strict_types=1);

namespace CodeSourceStudio\LaravelPermission\Commands;

use CodeSourceStudio\LaravelPermission\Models\Permission;
use Illuminate\Console\Command;

class CreatePermissionCommand extends Command
{
    protected $signature = 'permission:create-permission {name : The name of the permission}';

    protected $description = 'Create a permission';

    public function handle(): void
    {
        $permission = Permission::firstOrCreate(['name' => $this->argument('name')]);

        $this->info("Permission `{$permission->name}` ".($permission->wasRecentlyCreated ? 'created' : 'already exists'));
    }
}
