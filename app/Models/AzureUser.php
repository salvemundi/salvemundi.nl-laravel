<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AzureUser extends Model
{
    use HasFactory;
    protected $table = 'users';

    public function register(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(
            Inschrijving::class,
            'officeId',
            'id'
        );
    }
    public function payment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo
        (
            Transaction::class,
            'paymentId',
            'id',
            'transaction'
        );
    }
}
