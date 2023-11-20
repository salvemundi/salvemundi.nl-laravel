<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Merch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'merch';

    public function merchSizes(): BelongsToMany
    {
        return $this->belongsToMany
        (
            MerchSize::class,
            'merch_sizes_rel',
            'merch_id',
            'size_id'
        )->withPivot('amount');
    }

    public function userOrders(): BelongsToMany
    {
        return $this->belongsToMany
        (
            User::class,
            'user_merch_transaction',
            'merch_id',
            'user_id'
        )->withPivot('transaction_id')
            ->withTimestamps()
            ->with('transactions');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
