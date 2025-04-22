<?php

namespace App\Livewire\Admins\Customers\Components;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TransactionsChart extends Component
{
    public $customer;
    public $firstHalfSum;
    public $secondHalfSum;
    public $highestTransactionAmount;
    public $monthlyTransactions;
    public function mount($customerId)
    {
        $this->customer = Customer::find($customerId);
        $this->firstHalfSum = $this->getFirstHalfYearTransactionsSum();
        $this->secondHalfSum = $this->getSecondHalfYearTransactionsSum();
        $this->highestTransactionAmount =  $this->getHighestTransactionAmount();
        $this->monthlyTransactions = $this->getMonthlyTransactionSums();
    }
    public function getFirstHalfYearTransactionsSum()
    {
        $referenceNumber = $this->customer->reference_number;
        $customerId = $this->customer->id;
        $currentYear = now(env('APP_TIMEZONE', 'Africa/Nairobi'))->year; // Get the current year

        // Sum transactions from January to June of the current year
        $sum = DB::table('transactions')
            ->where(function ($query) use ($referenceNumber, $customerId) {
                $query->where('reference_number', $referenceNumber)
                    ->orWhere('customer_id', $customerId);
            })
            ->whereYear('trans_time', $currentYear) // Filter by current year
            ->whereMonth('trans_time', '>=', 1) // January
            ->whereMonth('trans_time', '<=', 6) // June
            ->sum('trans_amount');

        return $sum;
    }
    public function getSecondHalfYearTransactionsSum()
    {
        $referenceNumber = $this->customer->reference_number;
        $customerId = $this->customer->id;
        $currentYear = now(env('APP_TIMEZONE', 'Africa/Nairobi'))->year;

        return Transaction::where(function ($query) use ($referenceNumber, $customerId) {
            $query->where('reference_number', $referenceNumber)
                ->orWhere('customer_id', $customerId);
        })
            ->whereYear('trans_time', $currentYear)
            ->whereMonth('trans_time', '>=', 7) // July
            ->whereMonth('trans_time', '<=', 12) // December
            ->sum('trans_amount');
    }
    function getHighestTransactionAmount()
    {
        $referenceNumber = $this->customer->reference_number;
        $customerId = $this->customer->id;
        $currentYear = now(env('APP_TIMEZONE', 'Africa/Nairobi'))->year; // Get the current year

        $highestAmount = DB::table('transactions')
            ->where(function ($query) use ($referenceNumber, $customerId) {
                $query->where('reference_number', $referenceNumber)
                    ->orWhere('customer_id', $customerId);
            })
            ->whereYear('trans_time', $currentYear)
            ->max('trans_amount'); // Get the highest value in the trans_amount column

        return $highestAmount;
    }
    public function getMonthlyTransactionSums()
    {
        $currentYear = date('Y'); // Get the current year
        $referenceNumber = $this->customer->reference_number;
        $customerId = $this->customer->id;

        $monthlySums = DB::table('transactions')
            ->selectRaw('MONTH(trans_time) as month, COALESCE(SUM(trans_amount), 0) as total')
            ->whereYear('trans_time', $currentYear) // Filter by the current year
            ->where(function ($query) use ($referenceNumber, $customerId) {
                $query->where('reference_number', $referenceNumber)
                    ->orWhere('customer_id', $customerId);
            })
            ->groupBy(DB::raw('MONTH(trans_time)')) // Group by the month
            ->get()
            ->pluck('total', 'month'); // Create a key-value pair with month as key

        // Ensure all months are present with a default value of 0
        for ($month = 1; $month <= 12; $month++) {
            $results[] = $monthlySums->get($month, 0); // Append the total or 0 for missing months
        }

        return $results;
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
        return view('livewire.admins.customers.components.transactions-chart');
    }
}
