<?php

namespace App\Livewire\Forms\isp;

use App\Models\Customer;
use App\Models\StaticUser;
use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Services\RouterosApiService;
use Illuminate\Support\Facades\Hash;
use App\Models\Mikrotik;
use Illuminate\Support\Facades\Validator;

class CreateStatic extends Form
{
    #[Validate('required|unique:static_users,mikrotik_name')]
    public $username;

    #[Validate('required')]
    public $officialName;

    public $email;

    #[Validate('required|ip')]
    public $ip;

    // #[Validate('required|in:yes,no')]
    // public $status;

    public $location;

    #[Validate('required|regex:/^\d+[GMgmk]\/\d+[GMgmk]$/', message: 'The max limit must be in the format of number[G|M|g|m|k]/number[G|M|g|m|k]. For example: 10M/5M')]
    public $maxLimit;

    #[Validate('required|unique:customers,reference_number')]
    public $referenceNumber;

    #[Validate('required|numeric')]
    public $bill;

    #[Validate('required|in:days,weeks,months,years')]
    public $billingCycle;
    #[Validate('required|integer')]
    public $billingCycleValue;

    #[Validate('required|numeric|min:10')]
    public $phone;

    #[Validate('required')]
    public $expiryDate;

    public $comment;
    public $routerId;
    public $servicePlanId;
    public $sendSms;
    public $sendEmail;
    public $is_parent = false;
    public $parentAccount;
    public $service_plan_id;

    public function create()
    {
        try {
            $this->expiryDate = \Carbon\Carbon::parse($this->expiryDate)->format('Y-m-d H:i:s');
            $this->comment = $this->username . " has been successfully created at " . now(env('TIME_ZONE'))->format('d-m-Y H:i:s') . " by " . request()->ip();
            $billing = $this->getBillingCycle($this->billingCycle, $this->billingCycleValue);

            $connect = Mikrotik::getLoginCredentials($this->routerId);
            $userData = [
                'username' => $this->username,
                'target_address' => $this->ip,
                'max_limit' =>  now(env('APP_TIMEZONE', 'Africa/Nairobi'))->startOfDay()->gt(\Carbon\Carbon::parse($this->expiryDate)) ? '1k/1k' : $this->maxLimit,
                'status' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->startOfDay()->gt(\Carbon\Carbon::parse($this->expiryDate)) ? 'no' : 'yes',
                'disabled' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->startOfDay()->gt(\Carbon\Carbon::parse($this->expiryDate)) ? 'no' : 'yes',
                'comment' => $this->comment,
            ];
            $routerStatus = Mikrotik::createStaticUser($connect, $userData);
            if ($routerStatus === true) {
                $customer = Customer::create([
                    'username' => $this->referenceNumber,
                    'official_name' => $this->officialName,
                    'email' => $this->email,
                    'reference_number' => $this->referenceNumber,
                    'billing_amount' => $this->bill,
                    'billing_cycle' => $billing,
                    'phone_number' => $this->phone,
                    'password' => Hash::make($this->phone),
                    'connection_type' => 'static',
                    'expiry_date' => $this->expiryDate,
                    'comment' => $this->comment,
                    // 'status' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->startOfDay()->gt(\Carbon\Carbon::parse($this->expiryDate)) ? 'active' : 'inactive',
                    'status' => 'active',
                    'location' => $this->location,
                    'mikrotik_id' => $this->routerId,
                    'service_plan_id' => $this->service_plan_id,
                    'parent_account' => $this->parentAccount,
                    'is_parent' => $this->is_parent,
                ]);

                if ($this->parentAccount) {
                    Customer::where('id', $this->parentAccount)->update([
                        'is_parent' => true,
                    ]);
                }

                $staticCustomer = StaticUser::create([
                    'customer_id' => $customer->id,
                    'mikrotik_name' => $this->username,
                    'target_address' => $this->ip,
                    'max_download_speed' => $this->maxLimit,
                    'disabled' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->startOfDay()->gt(\Carbon\Carbon::parse($this->expiryDate)) ? 0 : 1,
                    'comment' => $this->comment,
                ]);
                return true;
            } else {
                return 'There has been an issue writing data to the mikrotik';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    private function getBillingCycle(string $billingCycle, int $billingCycleValue): string
    {
        $cycles = [
            "days" => "day",
            "weeks" => "week",
            "months" => "month",
            "years" => "year",
        ];

        return $billingCycleValue . ' ' . ($billingCycleValue > 1 ? $cycles[$billingCycle] . 's' : $cycles[$billingCycle]);
    }
}
