<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['imgPath'];

    public function transactions(): HasMany
    {
        return $this->hasMany
        (
            Transaction::class,
            'productId',
            'id'
        );
    }
    public function users()
    {
        return $this->hasManyThrough(Transaction::class, User::class);
    }
}
