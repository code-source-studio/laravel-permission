<?php

namespace CodeSourceStudio\LaravelPermission\Traits;

use BackedEnum;
use CodeSourceStudio\LaravelPermission\Models\Group;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;
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

    public function hasPermission(BackedEnum|string $name): bool
    {
        if ($name instanceof BackedEnum) {
            $name = $name->value;
        }

        return $this->getAllPermissions()->has(strtolower($name));
    }

    public function hasAnyPermissions(array $names): bool
    {
        $processedNames = array_map(function ($name) {
            if ($name instanceof BackedEnum) {
                $name = $name->value;
            }
            return strtolower($name);
        }, $names);

        return $this->getAllPermissions()->contains($processedNames);
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

    public function scopeRole(Builder $query, array|string|Collection $roles): Builder
    {
        if ($roles instanceof Arrayable) {
            $roles = $roles->toArray();
        }

        if (is_array($roles)) {
            return $query->whereIn('name', $roles);
        }

        return $query->where('name', $roles);
    }
}
