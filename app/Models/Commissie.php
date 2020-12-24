<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commissie extends Model
{
    use HasFactory;
    protected $table = 'groups';
    public function users()
    {
        return $this->belongsToMany
        (
            AzureUser::class,
            'groups_relation',
            'group_id',
            'user_id'
        );
    }
}
