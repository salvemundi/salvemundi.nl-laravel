<?php

namespace App\Models;

use App\Enums\paymentType;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable;

    public function inschrijving()
    {
        return $this->hasOne(
            Inschrijving::class,
            'userId',
            'id'
        );
    }

    public function getInvoiceInformation()
    {
        return [$this->name, $this->email];
    }
    /**
     * Get additional information to be displayed on the invoice. Typically a note provided by the customer.
     *
     * @return string|null
     */
    public function getExtraBillingInformation()
    {
        return null;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'birthday'
    ];

    public function mollieCustomerFields(): array
    {
        return [
            'email' => $this->email,
            'name' => $this->name,
        ];
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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
    public function activities(): BelongsToMany
    {
        return $this->belongsToMany
        (
            Product::class,
            'activity_user',
            'userId',
            'activityId'
        );
    }
    public function stickers()
    {
        return $this->hasMany(Sticker::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany
        (
            Permission::class,
            'permissions_users',
            'user_id',
            'permission_id'
        );
    }

    public function hasActiveSubscription(): bool
    {
        $planCommissieLid = paymentType::fromValue(1);
        $plan = paymentType::fromValue(2);
        $name = ucfirst($plan) . ' membership';
        $nameCommissieLid = ucfirst($planCommissieLid) . ' membership';
        return $this->subscribed($name,$plan->key) || $this->subscribed($nameCommissieLid,$planCommissieLid->key);
    }
}
