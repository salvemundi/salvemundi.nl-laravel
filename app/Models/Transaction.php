<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction';
    protected $fillable = ['formsLink'];

//    public function merch(): HasMany
//    {
//        return $this->hasMany
//        (
//            Merch::class,
//            'transaction_id',
//            'id'
//        );
//    }

    public function merch(): belongsTo
    {
        return $this->belongsTo
        (
            Merch::class,
            'merchId',
            'id',
            'merch'
        );
    }

    public function nonMembers(): HasMany
    {
        return $this->hasMany
        (
            NonUserActivityParticipant::class,
            'transactionId',
            'id'
        );
    }

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
            User::class,
            'userpayment',
            'payment_id',
            'user_id'
        );
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo
        (
            Product::class,
            'productId',
            'id',
            'products'
        );
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }
}
