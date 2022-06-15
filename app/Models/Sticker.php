<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sticker extends Model
{
    use HasFactory;
    protected $table = 'sticker';

    // Remove for later
    protected $connection = 'mysql2';
    protected $fillable = ['userId','latitude', 'longitude'];
}
