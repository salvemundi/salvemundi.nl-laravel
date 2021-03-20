<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Commissie extends Model
{
    use HasFactory;
    protected $table = 'groups';
    public function users(): BelongsToMany
    {
        return $this->belongsToMany
        (
            User::class,
            'groups_relation',
            'group_id',
            'user_id'
        );
    }
}
