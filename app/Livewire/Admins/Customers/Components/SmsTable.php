<?php

namespace App\Livewire\Admins\Customers\Components;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SmsTable extends Component
{
    public $customerId;
    public $search;
    public function mount($customerId)
    {
        $this->customerId = $customerId;
    }
    public function render()
    {
        $sentSms = DB::table('sms')
            ->where('customer_id', $this->customerId)
            ->where(function ($query) {
                $query->where('recipient', 'like', '%' . $this->search . '%')
                    ->orWhere('message', 'like', '%' . $this->search . '%')
                    ->orWhere('message_id', 'like', '%' . $this->search . '%')
                    ->orWhere('subject', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(5);
        return view('livewire.admins.customers.components.sms-table', [
            'allSms' => $sentSms
        ]);
    }
}
