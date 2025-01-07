<?php

declare(strict_types=1);

namespace CodeSourceStudio\LaravelPermission\Models;

use BackedEnum;
use CodeSourceStudio\LaravelPermission\Exceptions\PermissionDoesNotExist;
use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property Carbon $created_at
 * @property int $id
 * @property string $name
 * @property Carbon $updated_at
 */
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
     * @return Attribute<void, string>
     */
    protected function name(): Attribute
    {
        return new Attribute(
            set: function (string|BackedEnum $value): string {
                if ($value instanceof BackedEnum) {
                    return (string) $value->value;
                }

                return $value;
            }
        );
    }

    /**
     * @throws Exception
     */
    public function addPermission(BackedEnum|string $permissionName): void
    {
        if ($permissionName instanceof BackedEnum) {
            $permissionName = (string) $permissionName->value;
        }

        $permission = Permission::where('name', $permissionName)->first();

        if (! $permission) {
            throw new PermissionDoesNotExist($permissionName);
        }

        $this->permissions()->syncWithoutDetaching([$permission->id]);
    }

    /**
     * @throws Exception
     */
    public function removePermission(BackedEnum|string $permissionName): void
    {
        if ($permissionName instanceof BackedEnum) {
            $permissionName = (string) $permissionName->value;
        }

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
