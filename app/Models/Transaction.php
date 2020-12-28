<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction';
    public function introRelation(): HasOne
    {
        return $this->hasOne
        (
            Intro::class,
            'paymentId',
            'id'
        );
    }

    public function registerRelation(): HasOne
    {
        return $this->hasOne
        (
            Inschrijving::class,
            'paymentId',
            'id'
        );
    }

    public function contribution(): BelongsToMany
    {
        return $this->belongsToMany
        (
            AzureUser::class,
            'userpayment',
            'payment_id',
            'user_id'
        );
    }

    public function product(): BelongsToMany
    {
        return $this->belongsToMany
        (
            Product::class,
            'producttransaction',
            'transaction_id',
            'product_id'
        );
    }
}
