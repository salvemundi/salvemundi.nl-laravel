<?php

namespace App\Models;

use App\Enums\paymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    use HasFactory;

    /**
     * @var bool|\Illuminate\Support\HigherOrderCollectionProxy|mixed
     */
    protected $table = 'products';
    protected $fillable = ['imgPath','membersOnlyContent','isGroupSignup'];
    protected $dates = ['startDate', 'endDate'];

    protected $casts = [
        'startDate' => 'datetime', // or 'datetime:Y-m-d H:i:s' if your format is different
        'endDate' => 'datetime',   // or 'datetime:Y-m-d H:i:s'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany
        (
            Transaction::class,
            'productId',
            'id'
        );
    }

    public function associations(): HasMany
    {
        return $this->hasMany
        (
            ActivityAssociation::class,
            'activityId',
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

    public function users(): HasManyThrough
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
    public function countSignups(): int {
        $nonMembers = [];
        $count = $this->members->count();
        foreach($this->transactions as $transaction) {
            if($transaction->paymentStatus == paymentStatus::paid) {
                if($transaction->email != null && $transaction->email != ""){
                    $userTransaction = [$transaction->email, $transaction->name, $transaction->transactionId];
                    $nonMembers[] = $userTransaction;
                } else {
                    $count += $transaction->nonMembers->count();
                }
            }
        }
        if($this->amount_non_member > 0) {
            $count += count($nonMembers);
        } else {
            $count += $this->nonMembers->count();
        }

        return $count;
    }
    public function isFull(): bool
    {
        if($this->limit == 0) {
            return false;
        }
        return $this->countSignups() >= $this->limit;
    }
}
