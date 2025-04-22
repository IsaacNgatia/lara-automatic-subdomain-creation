<?php

namespace App\Livewire\Client\Dashboard;

use App\Models\Complaint;
use Livewire\Component;

class RecentTickets extends Component
{
    public $tickets;

    public function mount()
    {
        $this->tickets = Complaint::where('customer_id', auth()->guard('client')->user()->id)->latest()->take(5)->get();
    }

    public function render()
    {
        return view('livewire.client.dashboard.recent-tickets');
    }
}
