<?php

namespace App\Livewire\Admins\Dashboard;

use App\Models\Expense;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DebitCredit extends Component
{
    public $monthlyDebit;
    public $monthlyCredit;
    public $selectedYear;
    public $earliestYear;
    public $currentYear;
    /**
     * Initialize the component and calculate the monthly debit.
     *
     * This method retrieves the sum of transaction amounts for each month from the start of the year to the current month.
     * If there are no transactions for a particular month, it initializes the value to 0.
     *
     * @return void
     */
    public function mount()
    {
        $this->selectedYear = now()->year; // Set the selected year to the current year
        // Calculate the sum of trans_amount for each month from the start of the year to the current month
        $this->monthlyDebit = $this->getMonthlyTransactionSums($this->selectedYear);
        $this->monthlyCredit = $this->getMonthlyExpenseSums($this->selectedYear);
        $this->earliestYear = DB::table('transactions')
            ->selectRaw('YEAR(MIN(created_at)) as earliest_year')
            ->value('earliest_year');
        $this->currentYear = now()->year; // Set the current year to the current year
    }
    public function updatedSelectedMonth()
    {
        $this->monthlyDebit = $this->getMonthlyTransactionSums((int)$this->getMonthlyExpenseSums);
        $this->monthlyCredit = $this->getMonthlyExpenseSums((int)$this->getMonthlyExpenseSums);
        $this->dispatch('update-yearly-debit-credit', monthlyIncome: $this->monthlyDebit, monthlyExpense: $this->monthlyCredit);
    }
    public function getMonthlyTransactionSums($year)
    {
        // Initialize an array with all months (1 to current month) set to 0
        $monthlySums = array_fill(1, Carbon::now()->month, 0);

        // Get actual sums from the database
        $results = Transaction::selectRaw('MONTH(created_at) as month, SUM(trans_amount) as total_amount')
            ->whereYear('created_at', $year) // Filter for the current year
            ->groupBy(DB::raw('MONTH(created_at)')) // Group by month
            ->get();


        // Merge actual sums with the default array
        foreach ($results as $result) {
            $monthlySums[$result->month] = (float) $result->total_amount; // Use float for numeric precision
        }

        return array_values($monthlySums); // Return as a simple indexed array
    }
    public function getMonthlyExpenseSums($year)
    {
        // Initialize an array with all months (1 to current month) set to 0
        $monthlySums = array_fill(1, Carbon::now()->month, 0);

        // Get actual sums from the database
        $results = Expense::selectRaw('MONTH(created_at) as month, SUM(amount) as total_amount')
            ->whereYear('created_at', $year) // Filter for the current year
            ->groupBy(DB::raw('MONTH(created_at)')) // Group by month
            ->get();


        // Merge actual sums with the default array
        foreach ($results as $result) {
            $monthlySums[$result->month] = (float) $result->total_amount; // Use float for numeric precision
        }

        return array_values($monthlySums); // Return as a simple indexed array
    }
    public function render()
    {
        return view('livewire.admins.dashboard.debit-credit');
    }
}
