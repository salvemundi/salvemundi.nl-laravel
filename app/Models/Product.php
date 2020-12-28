<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    
    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany
        (
            Transaction::class,
            'producttransaction', 
            'product_Id',
            'transaction_id'

        );
    }
}
