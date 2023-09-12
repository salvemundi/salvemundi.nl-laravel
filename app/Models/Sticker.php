<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sticker extends Model
{
    use HasFactory;
    protected $table = 'sticker';

    protected $fillable = ['userId','latitude', 'longitude'];
    public function user(): BelongsTo
    {
        return $this->belongsTo
        (
            User::class,
            'userId',
            'id',
            'users'
        );
    }
}
