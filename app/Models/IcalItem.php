<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IcalItem extends Model
{
    use HasFactory;

    protected $table = 'calendar';
    protected $fillable = ['title','description','startDate','endDate'];
}
