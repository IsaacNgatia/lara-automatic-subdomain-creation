<?php

namespace App\Livewire\Admins\Customers\Components;

use App\Models\Customer;
use App\Models\Transaction;
use Livewire\Component;

class UserProfile extends Component
{
    public $customer;
    public $user;
    public $transactionsCount;
    public $mikrotikName;
    public function mount($customerId)
    {
        $this->customer = Customer::find($customerId);
        $this->mikrotikName = $this->customer->mikrotik->name;
        $referenceNumber = $this->customer->reference_number;
        $this->transactionsCount = Transaction::where(function ($query) use ($referenceNumber, $customerId) {
            $query->where('reference_number', $referenceNumber)
                ->orWhere('customer_id', $customerId);
        })->count();
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
    public function render()
    {
        return view('livewire.admins.customers.components.user-profile');
    }
}
