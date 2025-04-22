<?php

namespace App\Livewire\Admins\Customers\Components;

use App\Models\Customer;
use App\Models\Mikrotik;
use App\Models\Sms;
use App\Models\Transaction;
use Livewire\Attributes\On;
use Livewire\Component;

class UserProfile extends Component
{
    public $customer;
    public $user;
    public $transactionsCount;
    public $mikrotikName;
    public $customerId;
    public $mikrotikInfo;
    public $routerIsOnline = false;
    public $smsCount;

    public function mount($customerId)
    {
        $this->customerId = $customerId;
        $this->customer = Customer::find($customerId);
        $this->mikrotikName = $this->customer->mikrotik->name;
        $referenceNumber = $this->customer->reference_number;
        $this->transactionsCount = Transaction::where(function ($query) use ($referenceNumber, $customerId) {
            $query->where('reference_number', $referenceNumber)
                ->orWhere('customer_id', $customerId);
        })->count();
        $this->smsCount = Sms::where('customer_id', $customerId)->count();
        if ($this->customer['connection_type'] == 'pppoe') {
            $this->user = $this->customer->pppoeUser;
        } elseif ($this->customer['connection_type'] == 'static') {
            $this->user = $this->customer->staticUser;
        }
    }
    public function formatPhoneNumber($number)
    {
        // Remove any non-digit characters
        $number = preg_replace('/\D/', '', $number);

        // Check if the number starts with 07 or 01
        if (preg_match('/^(07|01)\d{8}$/', $number)) {
            // Replace the starting 0 with +254
            $formatted = preg_replace('/^(0)/', '+254 ', $number);

            // Format the rest of the number
            $formatted = preg_replace('/(\d{3})(\d{3})(\d{3})$/', '$1-$2-$3', $formatted);

            return $formatted;
        }

        return $number;
    }
    public function formatToK($value)
    {
        // Ensure the value is numeric
        if (!is_numeric($value)) {
            return $value;
        }

        // Check if the value is greater than 1000
        if ($value > 1000) {
            // Divide by 1000 and append 'K'
            return round($value / 1000, 1) . 'K';
        }

        // Return the original value if it is 1000 or less
        return $value;
    }
    public function downCustomer($customerId)
    {
        if ($this->customer->connection_type === 'static') {
            $status =  Mikrotik::downStaticCustomer($customerId);
        } elseif ($this->customer->connection_type === 'pppoe') {
            $status =   Mikrotik::downPppoeCustomer($customerId);
        } elseif ($this->customer->connection_type === ' rhsp') {
            $status =  Mikrotik::downHotspotCustomer($customerId);
        }
        if ($status) {
            $this->customer->status = 'inactive';
        }
        $this->dispatch('check-router-is-online');
        return;
    }
    public function raiseCustomer($customerId)
    {
        if ($this->customer->connection_type === 'static') {
            $status = Mikrotik::raiseStaticCustomer($customerId);
        } elseif ($this->customer->connection_type === 'pppoe') {
            $status = Mikrotik::raisePppoeCustomer($customerId);
        } elseif ($this->customer->connection_type === ' rhsp') {
            $status =  Mikrotik::raiseHotspotCustomer($customerId);
        }
        if ($status) {
            $this->customer->status = 'active';
        }
        $this->dispatch('check-router-is-online');
        return;
    }
    public function getInitials($name)
    {
        $name = explode(' ', $name);
        $initials = '';
        foreach ($name as $n) {
            $initials .= strtoupper($n[0]);
        }
        return $initials;
    }
    #[On('check-router-is-online')]
    public function getMikrotikInfo()
    {
        $info = Customer::getDetailedMikrotikInfo($this->customerId);
        if ($info['success'] === true) {
            $this->mikrotikInfo = $info['user'];
            $this->routerIsOnline = true;
        }
    }
    public function render()
    {
        return view('livewire.admins.customers.components.user-profile');
    }
}
