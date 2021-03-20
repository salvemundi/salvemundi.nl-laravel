<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inschrijving extends Model
{
    use HasFactory;
    protected $table = 'register';
    protected $fillable = ['birthday'];

    public function payment(): BelongsTo
    {
        return $this->belongsTo
        (
            Transaction::class,
            'paymentId',
            'id',
            'transaction'
        );
    }
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
