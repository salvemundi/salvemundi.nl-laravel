<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MerchSize extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'merch_sizes';

    public function merch(): BelongsToMany
    {
        return $this->belongsToMany
        (
            Merch::class,
            'merch_sizes_rel',
            'size_id',
            'merch_id'
        )->withPivot('amount');
    }
}
