<?php

namespace CodeSourceStudio\LaravelPermission\Commands;

use CodeSourceStudio\LaravelPermission\Models\Group;
use Illuminate\Console\Command;

class ShowCommand extends Command
{
    protected $signature = 'permission:show {groupName? : The name of the group}';

    protected $description = 'Show a table of groups and permissions';

    public function handle(): void
    {
        $groupQuery = Group::query()->with('permissions');

        if ($this->argument('groupName')) {
            $groupQuery->where('name', $this->argument('groupName'));
        }

        $groups = $groupQuery->get();

        $this->table(['Group', 'Permissions'], $groups->map(function (Group $group) {
            return [
                $group->name,
                $group->permissions()->orderBy('name')->pluck('name')->implode("\n"),
            ];
        }));
    }
}
