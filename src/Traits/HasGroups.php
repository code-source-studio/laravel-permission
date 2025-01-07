<?php

namespace CodeSourceStudio\LaravelPermission\Traits;

use CodeSourceStudio\LaravelPermission\Models\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @mixin Model
 */
trait HasGroups
{
    /**
     * @return BelongsToMany<Group, $this>
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    public function hasGroup(string $name): bool
    {
        return $this->groups()->where('name', $name)->exists();
    }

    public function hasAnyGroups(array $names): bool
    {
        return $this->groups()->whereIn('name', $names)->exists();
    }

    public function hasPermission(string $name): bool
    {
        return $this->getAllPermissions()->has(strtolower($name));
    }

    public function hasAnyPermissions(array $names): bool
    {
        return $this->getAllPermissions()->contains(array_map('strtolower', $names));
    }

    public function getAllPermissions(): Collection
    {
        return $this->groups()
            ->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('name')
            ->unique();
    }
}
