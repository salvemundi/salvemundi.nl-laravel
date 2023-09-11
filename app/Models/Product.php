<?php

namespace App\Models;

use App\Enums\paymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;


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

    public function members(): BelongsToMany
    {
        return $this->belongsToMany
        (
            User::class,
            'activity_user',
            'activityId',
          'userId'
        );
    }

    public function nonMembers(): HasMany
    {
        return $this->hasMany
        (
            NonUserActivityParticipant::class,
            'activityId',
            'id'
        );
    }

    public function users()
    {
        return $this->hasManyThrough(Transaction::class, User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany
        (
            CommitteeTags::class,
            'activity_committee_tag',
            'activityId',
            'tagId'
        );
    }

    public function isFull(): bool
    {
        $nonMembers = [];
        if($this->limit == 0) {
            return false;
        }
        foreach($this->transactions as $transaction) {
            if($transaction->paymentStatus == paymentStatus::paid) {
                if($transaction->email != null && $transaction->email != ""){
                    $userTransaction = [$transaction->email, $transaction->name, $transaction->transactionId];
                    $nonMembers[] = $userTransaction;
                }
            }
        }
        $count = $this->members->count();
        if($this->amount_non_member > 0) {
            $count += count($nonMembers);
        } else {
            $count += $this->nonMembers->count();
        }
        return $count >= $this->limit;
    }
}
