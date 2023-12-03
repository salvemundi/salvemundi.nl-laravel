<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MerchColor extends Model
{
    use HasFactory;

    public function merch(): BelongsToMany
    {
        return $this->belongsToMany
        (
            Merch::class,
            'merch_color_rel',
            'color_id',
            'merch_id'
        );
    }
}
