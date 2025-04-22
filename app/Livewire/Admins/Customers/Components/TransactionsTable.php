<?php

namespace App\Livewire\Admins\Customers\Components;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class TransactionsTable extends Component
{
    use WithPagination;
    public $customer;
    public $search;
    public function mount($customerId)
    {
        $this->customer = Customer::find($customerId);
    }
    public function render()
    {
        $transactions = DB::table('transactions')
            ->where(function ($query) {
                $query->where('reference_number', $this->customer->reference_number)
                    ->orWhere('customer_id', $this->customer->id);
            })
            ->where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%')
                    ->orWhere('trans_id', 'like', '%' . $this->search . '%')
                    ->orWhere('trans_amount', 'like', '%' . $this->search . '%')
                    ->orWhere('reference_number', 'like', '%' . $this->search . '%')
                    ->orWhere('msisdn', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(4);

        return view('livewire.admins.customers.components.transactions-table', [
            'transactions' => $transactions,
        ]);
    }
}
