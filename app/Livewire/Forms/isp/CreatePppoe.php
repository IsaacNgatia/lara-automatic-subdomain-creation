<?php

namespace App\Livewire\Forms\isp;

use App\Models\PppoeUser;
use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Mikrotik;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class CreatePppoe extends Form
{
    #[Validate('required|unique:pppoe_users,mikrotik_name')]
    public $username;
    #[Validate('required')]
    public $officialName;
    public $email;
    #[Validate('required')]
    public $password;
    #[Validate('required')]
    public $profile;
    #[Validate('required')]
    public $service;
    public $location;
    public $remoteAddress;
    #[Validate('required|in:yes,no')]
    public $status = 'yes';
    #[Validate('required|unique:customers,reference_number')]
    public $referenceNumber;
    #[Validate('required|numeric')]
    public $bill;
    #[Validate('required')]
    public $billingCycle;
    #[Validate('required|numeric|min:1')]
    public $billingCycleValue;
    #[Validate('required|numeric|min:10')]
    public $phone;
    #[Validate('required')]
    public $expiryDate;
    public $comment;
    public $routerId;
    public $sendSms;
    public $sendEmail;
    public $parentAccount;
    #[Validate('nullable|numeric')]
    public $installationFee;

    public $service_plan_id;
    public $is_parent  = false;


    public function create()
    {
        try {
            $this->expiryDate = \Carbon\Carbon::parse($this->expiryDate)->format('Y-m-d H:i:s');
            $this->comment = $this->username . " has been successfully created at " . now(env('TIME_ZONE'))->format('d-m-Y H:i:s') . " by " . request()->ip();
            $billing = $this->getBillingCycle($this->billingCycle, $this->billingCycleValue);

            $connect = Mikrotik::getLoginCredentials($this->routerId);
            $userData = [
                "name" => $this->username,
                "password" => $this->password,
                "service" => $this->service,
                "profile" => $this->profile,
                "comment" => $this->comment,
                "disabled" => $this->status
            ];
            if ($this->remoteAddress) {
                $userData["remote-address"] = $this->remoteAddress;
            }
            $routerStatus = Mikrotik::createPppoeUser($connect, $userData);
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
                    'connection_type' => 'pppoe',
                    'expiry_date' => $this->expiryDate,
                    'comment' => $this->comment,
                    // 'status' => $this->status == 'yes' ? 'active' : 'inactive',
                    'status' => 'active',
                    'location' => $this->location,
                    'mikrotik_id' => $this->routerId,
                    'parent_account' => $this->parentAccount,
                    'installation_fee' => $this->installationFee,
                    'service_plan_id' => $this->service_plan_id,
                    'is_parent' => $this->is_parent,
                ]);

                if ($this->parentAccount) {
                    Customer::where('id', $this->parentAccount)->update([
                        'is_parent' => true,
                    ]);
                }

                $pppoeCustomer = PppoeUser::create([
                    'customer_id' => $customer->id,
                    'mikrotik_name' => $this->username,
                    'profile' => $this->profile,
                    'service' => $this->service,
                    'password' => $this->password,
                    'remote_address' => $this->remoteAddress,
                    'disabled' => $this->status == 'yes' ? 0 : 1,
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
