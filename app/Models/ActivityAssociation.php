<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityAssociation extends Model
{
    use HasFactory;

    protected $table = "activity_association";
    protected $fillable = ['name'];

    public function product(): BelongsTo
    {
        return $this->belongsTo
        (
            Product::class,
            'activityId',
            'id',
            'products'
        );
    }

}
