<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    public function users(): BelongsToMany
    {
        return $this->belongsToMany
        (
            User::class,
            'permissions_users',
            'permission_id',
            'user_id'
        );
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany
        (
            Commissie::class,
            'permissions_groups',
            'permission_id',
            'group_id'
        );
    }

    public function routes(): BelongsToMany
    {
        return $this->belongsToMany
        (
            Route::class,
            'route_permissions',
            'permission_id',
            'route_id'
        );
    }
}
