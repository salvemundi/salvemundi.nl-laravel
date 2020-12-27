<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
class AzureUser extends Model
{
    use HasFactory;
    protected $table = 'users';

//    public function register(): HasOne
//    {
//        return $this->hasOne
//        (
//            Inschrijving::class,
//            'officeId',
//            'id'
//        );
//    }

    public function payment(): BelongsToMany
    {
        return $this->belongsToMany
        (
            Transaction::class,
            'userpayment',
            'user_id',
            'payment_id'
        );
    }

    public function commission(): BelongsToMany
    {
        return $this->belongsToMany
        (
            Commissie::class,
            'groups_relation',
            'user_id',
            'group_id'
        );
    }

}
