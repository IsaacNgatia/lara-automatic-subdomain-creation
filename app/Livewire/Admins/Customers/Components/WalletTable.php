<?php

namespace App\Livewire\Admins\Customers\Components;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class WalletTable extends Component
{
    public $customer;
    public $search = '';
    public function mount($customerId)
    {
        $this->customer = Customer::find($customerId);
    }
    public function render()
    {
        $search = $this->search; // Assume $this->search contains the search query input

        $walletRecords = DB::table('wallets')
            ->join('transactions', 'wallets.transaction_id', '=', 'transactions.id')
            ->where('wallets.customer_id', $this->customer->id)
            ->where(function ($query) use ($search) {
                $query->where('transactions.first_name', 'like', '%' . $search . '%')
                    ->orWhere('transactions.trans_id', 'like', '%' . $search . '%')
                    ->orWhere('transactions.trans_amount', 'like', '%' . $search . '%')
                    ->orWhere('transactions.reference_number', 'like', '%' . $search . '%');
            })
            ->select(
                'wallets.*', // Select all fields from the wallets table
                'transactions.trans_id', // Add specific fields from the transactions table
                'transactions.trans_amount',
                'transactions.first_name',
                'transactions.reference_number',
                'transactions.trans_time'
            )
            ->orderBy('wallets.id', 'desc') // Sort results in descending order by wallet ID
            ->paginate(4); // Paginate results, 10 per page

        return view('livewire.admins.customers.components.wallet-table', [
            'wallets' => $walletRecords
        ]);
    }
}
