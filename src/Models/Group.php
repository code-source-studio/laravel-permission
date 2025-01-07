<?php

declare(strict_types=1);

namespace CodeSourceStudio\LaravelPermission\Models;

use CodeSourceStudio\LaravelPermission\Exceptions\PermissionDoesNotExist;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    protected $guarded = [];

    protected $table = 'groups';

    /**
     * @return BelongsToMany<Permission, $this>
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * @throws Exception
     */
    public function addPermission(string $permissionName): void
    {
        $permission = Permission::where('name', $permissionName)->first();

        if (! $permission) {
            throw new PermissionDoesNotExist($permissionName);
        }

        $this->permissions()->syncWithoutDetaching([$permission->id]);
    }

    /**
     * @throws Exception
     */
    public function removePermission(string $permissionName): void
    {
        $permission = Permission::where('name', $permissionName)->first();

        if (! $permission) {
            throw new PermissionDoesNotExist($permissionName);
        }

        $this->permissions()->detach([$permission->id]);
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
