<?php

namespace App\Livewire\Admins\Reports\Customers\Components;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CustomersReport extends Component
{
    use WithPagination;
    public $startingDate;
    public $endingDate;
    public $selectedCustomers = [];
    public $totalTransactionsAmount = 0;
    public $totalTransactionsCount = 0;
    public $perPage = 10;
    public function mount($startingDate, $endingDate, array $customersIds)
    {
        $this->startingDate = $startingDate;
        $this->endingDate = $endingDate;
        $this->selectedCustomers = $customersIds;
        $summary = $this->getTotalTransactionSummary(($customersIds));
        $this->totalTransactionsAmount = $summary->total_transactions_amount;
        $this->totalTransactionsCount = $summary->total_transactions_count;
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

    function getTotalTransactionSummary(array $customerIds)
    {
        return DB::table('transactions')
            ->join('customers', function ($join) {
                $join->on('transactions.customer_id', '=', 'customers.id')
                    ->on('transactions.customer_type', '=', 'customers.connection_type');
            })
            ->whereIn('customers.id', $customerIds)
            ->selectRaw('COALESCE(SUM(transactions.trans_amount), 0) AS total_transactions_amount, COUNT(transactions.id) AS total_transactions_count')
            ->first();
    }

    public function render()
    {
        $customerDetails = DB::table('customers')
            ->select(
                'customers.id',
                'customers.official_name',
                'customers.billing_amount',
                'customers.status',
                'customers.mikrotik_id',
                'customers.connection_type',
                'customers.reference_number',
                'customers.phone_number',
                'mikrotiks.name as mikrotik_name', // Fetch name from mikrotiks table
                DB::raw('(CASE
            WHEN customers.connection_type = "static"
            THEN (SELECT mikrotik_name FROM static_users WHERE static_users.customer_id = customers.id LIMIT 1)
            WHEN customers.connection_type = "pppoe"
            THEN (SELECT mikrotik_name FROM pppoe_users WHERE pppoe_users.customer_id = customers.id LIMIT 1)
            ELSE NULL
        END) AS username'),
                DB::raw('COALESCE(SUM(transactions.trans_amount), 0) AS total_transactions_amount'),
                DB::raw('COUNT(transactions.id) AS total_transactions_count')
            )
            ->leftJoin('transactions', function ($join) {
                $join->on('transactions.customer_id', '=', 'customers.id')
                    ->on('transactions.customer_type', '=', 'customers.connection_type')
                    ->whereBetween('transactions.trans_time', [$this->startingDate, $this->endingDate]);
            })
            ->leftJoin('mikrotiks', 'mikrotiks.id', '=', 'customers.mikrotik_id') // Join with mikrotiks table
            ->whereIn('customers.id', $this->selectedCustomers)
            ->groupBy(
                'customers.id',
                'customers.official_name',
                'customers.billing_amount',
                'customers.status',
                'customers.mikrotik_id',
                'customers.connection_type',
                'mikrotiks.name', // Include in GROUP BY
                'customers.reference_number',
                'customers.phone_number'
            )
            ->paginate($this->perPage);

        return view('livewire.admins.reports.customers.components.customers-report', ['customers' => $customerDetails]);
    }
}
