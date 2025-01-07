<?php

declare(strict_types=1);

namespace CodeSourceStudio\LaravelPermission\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property Carbon $created_at
 * @property int $id
 * @property string $name
 * @property Carbon $updated_at
 */
class Permission extends Model
{
    protected $guarded = [];

    protected $table = 'permissions';

    /**
     * @return BelongsToMany<Group, $this>
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
