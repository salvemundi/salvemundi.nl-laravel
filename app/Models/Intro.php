<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Intro extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'introduction';
    protected $fillable = ['projectId'];

    public function payment(): hasOne
    {
        return $this->hasOne
        (
            Transaction::class,
            'productId',
            'id'
        );
    }
}
