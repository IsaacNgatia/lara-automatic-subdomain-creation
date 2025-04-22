<?php

namespace App\Livewire\Admins\Payments\CashPurchase;

use App\Models\Customer;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SelectCustomer extends Component
{
    public $userType;
    public $customers;
    #[Validate('required')]
    public $selectedCustomer;
    public $createPurchase = false;

    public function mount()
    {
        $this->userType = 'all';
        $this->customers = Customer::select('id', 'official_name', 'connection_type')->get();
    }
    public function updatedUserType($value)
    {
        if ($value === 'all') {
            $this->customers =  Customer::select('id', 'official_name', 'connection_type')->get();
        } else {
            $this->customers =  Customer::select('id', 'official_name', 'connection_type')->where('connection_type', $value)->get();
        }
    }
    public function createPurchaseForSelectedCustomer()
    {
        $this->validate();
        $this->createPurchase = true;
    }
    public function render()
    {
        return view('livewire.admins.payments.cash-purchase.select-customer');
    }
}
