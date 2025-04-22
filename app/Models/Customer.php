<?php

namespace App\Models;

use App\Services\RouterosApiService;
use App\Services\SmsService;
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
use Illuminate\Support\Facades\DB;

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
        'note',
        'is_parent',
        'updated_at',
        'created_at'
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
    public function recurringHotspotUser(): HasOne
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

    public function downCustomer($customerId)
    {
        $customer = Customer::find($customerId);
    }
    public static function getDetailedMikrotikInfo($customerId)
    {
        $customer = Customer::find($customerId);
        if (!$customer) {
            return ['success' => false, 'message' => 'customer is missing'];
        }
        $routerosApiService = app(RouterosApiService::class);
        if (Mikrotik::checkRouterStatus(Mikrotik::getLoginCredentials($customer->mikrotik->id)) === true) {
            if ($customer->connection_type === 'pppoe') {
                $active = $routerosApiService->comm(
                    "/ppp/active/print",
                    array(
                        "?name" => $customer->pppoeUser->mikrotik_name,
                    )
                );
                $secret = $routerosApiService->comm(
                    "/ppp/secret/print",
                    array(
                        "?name" => $customer->pppoeUser->mikrotik_name,
                    )
                );

                $secret = $secret[0];
                $active = !empty($active) ? $active[0] : null;
                return [
                    'success' => true,
                    'user' => [
                        'mac-address' => $active['caller-id'] ?? null,
                        'uptime' => $active['uptime'] ?? null,
                        'ip-address' => $active['address'] ?? null,
                        'last-logged-out' => $secret['last-logged-out']
                    ]
                ];
            } elseif ($customer->connection_type === 'static') {
                $queue = $routerosApiService->comm(
                    "/queue/simple/print",
                    array(
                        "?name" => $customer->staticUser->mikrotik_name
                    )
                );
                if (isset($queue['!trap'][0])) {
                    dd($queue['!trap'][0]['message']);
                }

                $queue = $queue[0];

                return [
                    'success' => true,
                    'user' => [
                        'max-limit' => self::formatBandwidthForSimpleQueue($queue['max-limit']),
                        'target' => $queue['target'],
                        'burst-limit' => self::formatBandwidthForSimpleQueue($queue['burst-limit']),
                        'burst-time' => $queue['burst-time']
                    ]
                ];
            }
        }
    }
    public static function activateCustomerOnAmountPaid($amount, $id)
    {
        try {
            //code...

            // Check for related accounts for customer
            $relatedAccounts = self::getRelatedAccounts($id);
            $customerDetails = $relatedAccounts['customer_details'][0];
            $parentDetails = $relatedAccounts['parent_details'];
            $children = $relatedAccounts['children'];
            $siblings = $relatedAccounts['siblings'];

            $smsService = app(SmsService::class);


            if ($amount < $customerDetails->billing_amount) {
                SystemLog::create([
                    'level' => 'WARNING',
                    'event_type' => 'Subscription',
                    'message' => 'Received less amount for user ' . $customerDetails->official_name,
                    'status' => 'success',
                    'description' => 'Accumulated amount totaled to ' . $amount . ' but the amount expected was ' . $customerDetails->billing_amount

                ]);
                return response()->json(['success' => true, 'message' => 'Funds received successfully']);
            }
            $balance = $amount - $customerDetails->billing_amount;
            // Calculate the expiry date
            $customerDetails->expiry_date = self::calculateNewExpiryDate(Carbon::parse($customerDetails->expiry_date), $customerDetails->billing_cycle, isset($customerDetails->grace_date) ? Carbon::parse($customerDetails->grace_date) :  null)->format('Y-m-d H:i:s');
            DB::table('customers')->where('id', $customerDetails->id)->update(['expiry_date' => $customerDetails->expiry_date, 'grace_date' => null]);

            if ($customerDetails->connection_type === 'pppoe') {
                $raiseCustomer = Mikrotik::raisePppoeCustomer($customerDetails->id);
            } elseif ($customerDetails->connection_type === 'static') {
                $raiseCustomer = Mikrotik::raiseStaticCustomer($customerDetails->id);
            } elseif ($customerDetails->connection_type === 'rhsp') {
                $raiseCustomer = Mikrotik::raiseHotspotCustomer($customerDetails->id);
            }
            if ($raiseCustomer === false) {
                FailedConnection::create([
                    'customer_id' => $customerDetails->id,
                    'attempts' => '1',
                    'resolved' => 0,
                    'reason' => 'Router was offline'
                ]);
            } else {
                SystemLog::create([
                    'level' => 'INFO',
                    'event_type' => 'Customer Reconnection',
                    'message' =>  $customerDetails->official_name . ' (' . $customerDetails->reference_number . ') was raised successfully.',
                    'status' => 'success',
                    'description' => 'Customer ' . $customerDetails->reference_number . ' was successfully raised at ' . now(env('APP_TIMEZONE', 'Africa/Nairobi'))

                ]);
            }

            if ($relatedAccounts['is_parent'] == 1) {
                if (!empty($children)) {
                    foreach ($children as $child) {
                        if ($balance >= $child->billing_amount) {
                            $balance -= $child->billing_amount;
                            $childExpiry = self::calculateNewExpiryDate(Carbon::parse($child->expiry_date), $child->billing_cycle, isset($child->grace_date) ? Carbon::parse($child->grace_date) :  null)->format('Y-m-d H:i:s');
                            DB::table('customers')->where('id', $child->id)->update(['expiry_date' => $childExpiry, 'grace_date' => null]);
                            self::activateRelatedCustomerAndLog($child,  $childExpiry, 'child', $customerDetails->reference_number);
                            $smsService->send(['id' => $child->id], "Account " . $child->reference_number . ' subscription has been renewed successfully. New expiry date is: ' . $childExpiry, 'Acknowledgement');
                        } else {
                            continue;
                        }
                    }
                }
            } else {
                if (!empty($parentDetails)) {
                    if ($balance >= $parentDetails->billing_amount) {
                        $balance -= $parentDetails->billing_amount;
                        $parentExpiry = self::calculateNewExpiryDate(Carbon::parse($parentDetails->expiry_date), $parentDetails->billing_cycle, isset($parentDetails->grace_date) ? Carbon::parse($parentDetails->grace_date) :  null)->format('Y-m-d H:i:s');
                        DB::table('customers')->where('id', $parentDetails->id)->update(['expiry_date' => $parentExpiry, 'grace_date' => null]);
                        self::activateRelatedCustomerAndLog($parentDetails,  $parentExpiry, 'parent', $customerDetails->reference_number);

                        $smsService->send(['id' => $parentDetails->id], "Account " . $parentDetails->reference_number . ' subscription has been renewed successfully. New expiry date is: ' . $parentExpiry, 'Acknowledgement');
                    }
                }
                if (!empty($siblings)) {
                    foreach ($siblings as $sibling) {
                        if ($balance >= $sibling->billing_amount) {
                            $balance -= $sibling->billing_amount;
                            $siblingExpiry = self::calculateNewExpiryDate(Carbon::parse($sibling->expiry_date), $sibling->billing_cycle, isset($sibling->grace_date) ? Carbon::parse($sibling->grace_date) :  null)->format('Y-m-d H:i:s');
                            DB::table('customers')->where('id', $sibling->id)->update(['expiry_date' => $siblingExpiry, 'grace_date' => null]);
                            self::activateRelatedCustomerAndLog($sibling,  $siblingExpiry, 'sibling', $customerDetails->reference_number);
                            $smsService->send(['id' => $sibling->id], "Account " . $sibling->reference_number . ' subscription has been renewed successfully. New expiry date is: ' . $siblingExpiry, 'Acknowledgement');
                        } else {
                            continue;
                        }
                    }
                }
            }
            $remainingBalance = $balance;
            for ($i = 0; $i < (int)($balance / $customerDetails->billing_amount); $i++) {
                $remainingBalance -= $customerDetails->billing_amount;
                $customerDetails->expiry_date = self::calculateNewExpiryDate(Carbon::parse($customerDetails->expiry_date), $customerDetails->billing_cycle, isset($customerDetails->grace_date) ? Carbon::parse($customerDetails->grace_date) :  null)->format('Y-m-d H:i:s');
            }
            DB::table('customers')->where('id', $customerDetails->id)->update(['expiry_date' => $customerDetails->expiry_date, 'balance' => $remainingBalance]);
            return  true;
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }

    public static function getRelatedAccounts($customerId)
    {
        // Fetch the customer
        $customer = DB::table('customers')
            ->where('id', $customerId)
            ->select('id', 'official_name', 'expiry_date', 'grace_date', 'billing_amount', 'billing_cycle', 'phone_number', 'parent_account', 'is_parent', 'connection_type', 'reference_number')
            ->get();


        if (!$customer) {
            return ['error' => 'Customer not found'];
        }

        $relatedAccounts = [
            'is_parent' => null,
            'customer_details' => $customer,
            'parent_details' => [],
            'children' => [],
            'siblings' => []
        ];
        $customer = $customer[0];

        if (isset($customer->is_parent) && $customer->is_parent == 1) {
            // Fetch children
            $children = DB::table('customers')
                ->where('parent_account', $customerId)
                ->select('id', 'official_name', 'expiry_date', 'grace_date', 'billing_amount', 'billing_cycle', 'phone_number', 'connection_type', 'reference_number')
                ->get();

            $relatedAccounts['is_parent'] = 1;
            $relatedAccounts['children'] = $children;
        } else {
            // Fetch parent
            $parent = DB::table('customers')
                ->where('id', $customer->parent_account)
                ->select('id', 'official_name', 'expiry_date', 'grace_date', 'billing_amount', 'billing_cycle', 'phone_number', 'connection_type', 'reference_number')
                ->first();

            // Fetch siblings (excluding self)
            $siblings = DB::table('customers')
                ->where('parent_account', $customer->parent_account)
                ->where('id', '!=', $customerId)
                ->select('id', 'official_name', 'expiry_date', 'grace_date', 'billing_amount', 'billing_cycle', 'phone_number', 'connection_type', 'reference_number')
                ->get();

            $relatedAccounts['is_parent'] = 0;
            $relatedAccounts['parent_details'] = $parent;
            $relatedAccounts['siblings'] = $siblings;
        }

        return $relatedAccounts;
    }
    public static function processCashPurchaseDeposit($amountReceived, $customerId, $comment = null)
    {
        try {
            // Get the customer object
            $customer = Customer::find($customerId);

            // record transaction and log
            $names = splitName($customer->official_name);
            $transactionData = [
                'trans_id' => generateUniqueCashTransactionId(),
                'trans_amount' => $amountReceived,
                'trans_time' => now(env('APP_TIMEZONE', 'Africa/Nairobi')),
                'msisdn' => $customer->phone_number,
                'first_name' => $names['firstName'] ?? null,
                'middle_name' => $names['middleName'] ?? null,
                'last_name' => $names['lastName'] ?? null,
                'payment_gateway' =>  'cash',
                'is_known' => 1,
                'is_partial' => $amountReceived < $customer->billing_amount ? 1 : 0,
                'mikrotik_id' => $customer->mikrotik_id,
                'customer_id' => $customerId,
                'customer_type' => $customer->connection_type,
                'reference_number' => $customer->reference_number,
                'short_code' => 'cash',
                'trans_type' => 'subscription',
                'org_balance' =>  null,
                'comment' => $comment,
                'valid_from' => $customer->expiry_date,
                'updated_at' => now(env('APP_TIMEZONE', 'Africa/Nairobi')),
                'created_at' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))
            ];
            $transaction = Transaction::create($transactionData);
            // send ackowledgement
            $smsService = app(SmsService::class);
            $smsTemplate = SmsTemplate::where('subject', 'acknowledgement')->first();
            if (!empty($smsTemplate)) {
                $smsService->send(['id' => $customer->id], $smsTemplate->template, 'acknowledgement');
            }

            $total = $amountReceived + $customer->balance;

            if ($total < $customer->billing_amount) {
                $customer->update(['balance' => $total]);
                return ['success' => true, 'message' => "transaction recorded successfully and balance updated"];
            }
            // raise customer
            $activateUser = self::activateCustomerOnAmountPaid($total, $customerId);
            if ($activateUser === true) {
                $customer = Customer::find($customerId);
                $transaction->update(['valid_until' => $customer->expiry_date]);
            }
            return ['success' => true, 'message' => 'Transaction recorded succesfully and customer updated'];
        } catch (\Throwable $th) {
            //throw $th;
            return ['success' => true, 'message' => $th->getMessage()];
        }
    }
    static function formatBandwidthForSimpleQueue(string $bandwidth): string
    {
        $parts = explode('/', $bandwidth);
        $formatted = [];

        foreach ($parts as $part) {
            $formatted[] = self::formatBytesForSimpleQueue((int) $part);
        }

        return implode('/', $formatted);
    }

    static function formatBytesForSimpleQueue(int $bytes): string
    {
        $units = ['b', 'k', 'M', 'G', 'T'];
        $i = 0;

        while ($bytes >= 1000 && $i < count($units) - 1) {
            $bytes /= 1000;
            $i++;
        }

        // Round to the nearest whole number, or use `round($bytes, 2)` for decimals
        return round($bytes) . $units[$i];
    }
    private static function activateRelatedCustomerAndLog($accountDetails, $accountExpiry, $relation = 'customer', $primaryAccountReferenceNumber = null)
    {
        if ($accountDetails->connection_type === 'pppoe') {
            $raiseParent = Mikrotik::raisePppoeCustomer($accountDetails->id);
        } elseif ($accountDetails->connection_type === 'static') {
            $raiseParent = Mikrotik::raiseStaticCustomer($accountDetails->id);
        } elseif ($accountDetails->connection_type === 'rhsp') {
            $raiseParent = Mikrotik::raiseHotspotCustomer($accountDetails->id);
        }
        if ($raiseParent === false) {
            FailedConnection::create([
                'customer_id' => $accountDetails->id,
                'attempts' => '1',
                'resolved' => 0,
                'reason' => 'Router was offline'
            ]);
        } else {

            SystemLog::create([
                'level' => 'INFO',
                'event_type' => $relation . ' reconnection',
                'message' =>  $relation . ' ' . $accountDetails->reference_number . ' was raised successfully.',
                'status' => 'success',
                'description' => $relation . ' ' . $accountDetails->official_name . ' (' . $accountDetails->reference_number . ') was successfully raised at ' . now(env('APP_TIMEZONE', 'Africa/Nairobi')) .  ' through payment to ' . $primaryAccountReferenceNumber  . '. New Expiry Date: ' . $accountExpiry

            ]);
        }
        return true;
    }

    private static function calculateNewExpiryDate(Carbon $expiryDate, string $billingCycle = '1 month', ?Carbon $graceExpiry = null): Carbon
    {
        $now = now();

        if ($graceExpiry) {
            // We're within the grace period
            if ($now->between($expiryDate, $graceExpiry)) {
                return $expiryDate->copy()->add($billingCycle);
            }

            // Grace period has already passed
            if ($now->greaterThan($graceExpiry)) {
                $graceInterval = $expiryDate->diffAsCarbonInterval($graceExpiry);
                return $now->copy()->add($billingCycle)->sub($graceInterval);
            }
        }

        // Grace not set or we haven't reached expiry yet
        if ($now->lessThanOrEqualTo($expiryDate)) {
            return $expiryDate->copy()->add($billingCycle);
        }

        // No grace set, and we're past expiry
        return $now->copy()->add($billingCycle);
    }
}
