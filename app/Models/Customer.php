<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $guard = 'client';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    //  TODO::Add this house number
    protected $fillable = [
        'username',
        'official_name',
        'email',
        'reference_number',
        'phone_number',
        'password',
        'connection_type',
        'location',
        'mikrotik_id',
        'billing_amount',
        'balance',
        'billing_cycle',
        'status',
        'grace_date',
        'last_payment_date',
        'expiry_date',
        'parent_account',
        'installation_fee',
        'house_number',
        'service_plan_id',
        'is_parent'
    ];
    protected $hidden = [
        'password',
        'remember_token'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];
    protected $appends = [
        'profile_photo_url'
    ];

    /**
     * Get the Mikrotik that owns the customer.
     */
    /**
     * mikrotik
     *
     * @return BelongsTo
     */
    public function mikrotik(): BelongsTo
    {
        return $this->belongsTo(Mikrotik::class);
    }

    /**
     * Get the static customer associated with the customer.
     */
    /**
     * static
     *
     * @return HasOne
     */
    public function staticUsers(): HasOne
    {
        return $this->hasOne(StaticUser::class);
    }
    public function staticUser(): HasOne
    {
        return $this->hasOne(StaticUser::class, 'customer_id');
    }

    /**
     * Get the PPPoE customer associated with the customer.
     */
    /**
     * pppoe
     *
     * @return HasOne
     */
    public function pppoeUsers(): HasOne
    {
        return $this->hasOne(PppoeUser::class);
    }
    /**
     * Get the PPPoE customer associated with the customer.
     *
     * This method retrieves the PPPoE user record associated with the current customer.
     * It uses the 'customer_id' field to establish the relationship.
     *
     * @return HasOne
     * @return \Illuminate\Database\Eloquent\Relations\HasOne A relationship with PppoeUser model.
     */
    public function pppoeUser(): HasOne
    {
        return $this->hasOne(PppoeUser::class, 'customer_id');
    }
    public function recurrringHotspotUser(): HasOne
    {
        return $this->hasOne(HotspotRecurring::class, 'customer_id');
    }

    /**
     * Get the complaints for the customer.
     */
    /**
     * complaints
     *
     * @return HasMany
     */
    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }
    /**
     * Get the sent SMS records for the customer.
     *
     * @return HasMany
     * @return \Illuminate\Database\Eloquent\Relations\HasMany A relationship with SentSms model.
     */
    public function sentSms(): HasMany
    {
        return $this->hasMany(Sms::class);
    }

    /**
     * Scope a query to find a customer by reference number.
     */
    /**
     * scopeByReference
     *
     * @param  mixed $query
     * @param  mixed $reference
     * @return void
     */
    public function scopeByReference($query, $reference)
    {
        return $query->where('reference_number', $reference);
    }

    /**
     * Scope a query to only include non-expired customers.
     */
    /**
     * scopeNonExpired
     *
     * @param  mixed $query
     * @param  mixed $expiry
     * @return void
     */
    public function scopeNonExpired(Builder $query, Carbon $expiry): Builder
    {
        return $query->when(
            optional($query->first())->grace_expiry !== null &&
                $query->first()->grace_expiry < $expiry,
            fn($q) => $q->where('grace_date', '<=', $expiry)
        );
    }


    /**
     * Scope a query to only include expired customers.
     */
    /**
     * scopeExpired
     *
     * @param  mixed $query
     * @param  mixed $expiry
     * @return void
     */
    public function scopeExpiredButActive(Builder $query, $currentDateTime)
    {
        return Customer::where(function ($query) use ($currentDateTime) {
            $query->where(function ($subQuery) use ($currentDateTime) {
                // When grace_date is null, check only expiry_date
                $subQuery->whereNull('grace_date')
                    ->where('expiry_date', '<=', $currentDateTime);
            })->orWhere(function ($subQuery) use ($currentDateTime) {
                // When grace_date is not null, check both expiry_date and grace_date
                $subQuery->whereNotNull('grace_date')
                    ->where(function ($dateQuery) use ($currentDateTime) {
                        $dateQuery->where('expiry_date', '<=', $currentDateTime)
                            ->where('grace_date', '<=', $currentDateTime);
                    });
            });
        })->where('status', 'active')
            ->select('id', 'connection_type', 'mikrotik_id')
            ->get();
    }

    /**
     * Scope a query to find customers by location.
     */
    /**
     * scopeByLocation
     *
     * @param  mixed $query
     * @param  mixed $location
     * @return void
     */
    public function scopeByLocation(Builder $query, $location): Builder
    {
        return $query->where('location', $location);
    }

    public function getProfilePhotoUrlAttribute()
    {
        return;
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function childAccounts()
    {
        return $this->hasMany(Customer::class, 'parent_account');
    }

    public function parentAccount()
    {
        return $this->belongsTo(Customer::class, 'parent_account');
    }
}
