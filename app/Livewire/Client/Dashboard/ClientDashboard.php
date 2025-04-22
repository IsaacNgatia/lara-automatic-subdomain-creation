<?php

namespace App\Livewire\Client\Dashboard;

use App\Models\Customer;
use Livewire\Component;

class ClientDashboard extends Component
{
    public $profile;

    public function mount(){
        $this->profile = Customer::where('id', auth()->guard('client')->user()->id)->first();
    }
    public function render()
    {
        return view('livewire.client.dashboard.client-dashboard');
    }
}
