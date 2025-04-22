<?php

namespace App\Livewire\Admins\Customers\Components;

use App\Models\Customer;
use Livewire\Component;

class ChildAccounts extends Component
{
    public $childAccounts;
    public $customer;
    public function mount($customerId)
    {
        $this->customer = Customer::find($customerId);
    }
    public function render()
    {
        $this->childAccounts = $this->customer->childAccounts;
        return view('livewire.admins.customers.components.child-accounts', [
            'childAccounts' => $this->childAccounts
        ]);
    }
}
