<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Route extends Model
{
    use HasFactory;
    protected $table = "routes";

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany
        (
            Permission::class,
            'route_permissions',
            'route_id',
            'permission_id'
        );
    }
}
