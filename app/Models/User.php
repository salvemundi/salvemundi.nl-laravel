<?php

namespace App\Models;

use App\Enums\paymentType;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable, Billable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'birthday',
        'minecraftUsername',
        'visibility',
        'PhoneNumber',
        'DisplayName',
        'FirstName',
        'LastName',
    ];
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }

    public function getFilamentName(): string
    {
        return $this->email;
    }

    public function merchOrders(): BelongsToMany
    {
        return $this->belongsToMany
        (
            Merch::class,
            'user_merch_transaction',
            'user_id',
            'merch_id'
        )->withPivot(['merch_gender','merch_size_id','id','isPickedUp']);
    }

    public function getDisplayName(): string
    {
        return $this->DisplayName;
    }

    public function isCommitteeLeaderOfAnyCommittee(): bool {
        foreach($this->commission as $committee) {
            $isCommitteeLeader =  $this->commission->contains(function ($value, $key) use ($committee) {
                return $value->id === $committee->id && $value->pivot->isCommitteeLeader;
            });
            if($isCommitteeLeader) {
                return true;
            }
        }
        return false;
    }

    public function inschrijving()
    {
        return $this->hasOne(
            Inschrijving::class,
            'userId',
            'id'
        );
    }

    public function isAdmin() {
        foreach($this->commission as $commission) {
            if($commission->permissions->count() > 0){
                return true;
            }
        }
        return $this->permissions->count() > 0;
    }

    public function pizzas(): HasMany
    {
        return $this->hasMany(Pizza::class);
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
        )->withPivot('isCommitteeLeader');
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
