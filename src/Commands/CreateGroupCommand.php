<?php

declare(strict_types=1);

namespace CodeSourceStudio\LaravelPermission\Commands;

use CodeSourceStudio\LaravelPermission\Models\Group;
use Illuminate\Console\Command;

class CreateGroupCommand extends Command
{
    protected $signature = 'permission:create-group {name : The name of the group}';

    protected $description = 'Create a group';

    public function handle(): void
    {
        $group = Group::firstOrCreate(['name' => $this->argument('name')]);

        $this->info("Group `{$group->name}` ".($group->wasRecentlyCreated ? 'created' : 'already exists'));
    }
}
