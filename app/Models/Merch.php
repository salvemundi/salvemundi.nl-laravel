<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Merch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'merch';

    public bool $isNew;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        //dd($this->calculateIsNew());
        $this->isNew = $this->calculateIsNew();
    }

    public function calculateDiscount() {
        return $this->price - $this->discount;
    }

    public function calculateDiscountPercentage(): float|int
    {
        return round((($this->price - $this->calculateDiscount()) / $this->price) * 100);
    }

    private function calculateIsNew(): bool
    {
        return Carbon::parse($this->created_at)->diffInDays(Carbon::now()) < 15;
    }

    public function merchSizes(): BelongsToMany
    {
        return $this->belongsToMany
        (
            MerchSize::class,
            'merch_sizes_rel',
            'merch_id',
            'size_id'
        )->withPivot(['amount','merch_gender']);
    }

    public function merchColor(): BelongsToMany
    {
        return $this->belongsToMany
        (
            MerchColor::class,
            'merch_color_rel',
            'merch_id',
            'color_id'
        );
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
