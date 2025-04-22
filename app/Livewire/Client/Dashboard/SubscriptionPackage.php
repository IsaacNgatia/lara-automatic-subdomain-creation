<?php

namespace App\Livewire\Client\Dashboard;

use App\Models\Customer;
use Livewire\Component;

class SubscriptionPackage extends Component
{
    public $customer;
    public $subscriptionPackage;
    public function mount(){
        $this->customer = Customer::where('id', auth()->guard('client')->user()->id)->first();

        if($this->customer->connection_type == 'pppoe'){
            $this->subscriptionPackage = $this->customer->pppoeUser->profile;
        }else if($this->customer->connection_type == 'static'){
            $this->subscriptionPackage = $this->customer->staticUser->max_download_speed;
        }
    }
    public function render()
    {
        return view('livewire.client.dashboard.subscription-package');
    }
}
