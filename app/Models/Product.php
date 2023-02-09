<?php

namespace App\Models;

use App\Enums\paymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['imgPath','membersOnlyContent'];

    public function transactions(): HasMany
    {
        return $this->hasMany
        (
            Transaction::class,
            'productId',
            'id'
        );
    }
    public function users()
    {
        return $this->hasManyThrough(Transaction::class, User::class);
    }
    public function isFull(): bool
    {
        $transactions = $this->transactions->where('paymentStatus', paymentStatus::paid)->count();
        if($transactions >= $this->limit && $this->limit != 0) {
            return true;
        }
        return false;
    }

}
