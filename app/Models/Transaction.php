<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction';
    public function introRelation(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Intro::class,'paymentId','id');
    }
    public function registerRelation(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Inschrijving::class,'paymentId','id');
    }
}
