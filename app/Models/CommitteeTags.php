<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CommitteeTags extends Model
{
    use HasFactory;

    protected $table = 'committee_tags';
    protected $fillable = ['string', 'icon'];

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany
        (
            Product::class,
            'activity_committee_tag',
            'tagId',
            'activityId'
        );
    }
}
