<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $name
 * @property string $email
 */
class NonUserActivityParticipant extends Model
{
    use HasFactory;

    protected $table = "non_member_activity_signup";
    protected $fillable = ['name', 'email'];

    public function activity(): BelongsTo
    {
        return $this->belongsTo
        (
            Product::class,
            'activityId',
            'id',
        );
    }
}
