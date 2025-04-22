<?php

namespace App\Livewire\Admins\Dashboard;

use App\Models\Expense;
use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Component;

class EarningsReport extends Component
{
    public $dailyIncome;
    public $dailyExpense;
    public $months;
    public $selectedMonth;
    /**
     * Initializes the component by calculating the daily income and expense for the current month.
     *
     * @return void
     */
    public function mount()
    {
        $this->selectedMonth = Carbon::now()->month;
        $this->dailyIncome = $this->getDailyIncomeForMonth($this->selectedMonth);
        $this->dailyExpense = $this->getDailyExpenseForMonth($this->selectedMonth);
        for ($m = 1; $m <= 12; $m++) {
            $this->months[] = [
                'id' => $m,
                'name' => Carbon::create()->month($m)->format('F')
            ];
        }
    }
    public function updatedSelectedMonth()
    {
        $this->dailyIncome = $this->getDailyIncomeForMonth((int)$this->selectedMonth);
        $this->dailyExpense = $this->getDailyExpenseForMonth((int)$this->selectedMonth);
        $this->dispatch('update-earnings-chart', dailyIncome: $this->dailyIncome, dailyExpense: $this->dailyExpense);
    }
    /**
     * Calculates the daily income for a given month.
     *
     * @param int $currentMonth The month for which to calculate the daily income.
     *
     * @return array An array containing the daily income for each day of the given month.
     */
    protected function getDailyIncomeForMonth($currentMonth)
    {
        $daysInMonth = Carbon::now()->month($currentMonth)->daysInMonth;
        $dailyIncome = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::now()->startOfYear()->addMonths($currentMonth - 1)->addDays($day - 1);
            $dailyIncome[] = $this->calculateIncomeForDay($date);
        }

        return $dailyIncome;
    }
    /**
     * Calculates the daily expense for a given month.
     *
     * @param int $currentMonth The month for which to calculate the daily expense.
     *                          The month should be represented by a number between 1 (January) and 12 (December).
     *
     * @return array An array containing the daily expense for each day of the given month.
     *               Each element in the array represents the total expense for a specific day.
     *               The array is indexed by the day of the month (starting from 1).
     */
    protected function getDailyExpenseForMonth($currentMonth)
    {
        $daysInMonth = Carbon::now()->month($currentMonth)->daysInMonth;
        $dailyIncome = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::now()->startOfYear()->addMonths($currentMonth - 1)->addDays($day - 1);
            $dailyIncome[] = $this->calculateExpenseForDay($date);
        }

        return $dailyIncome;
    }

    /**
     * Calculates the total income for a specific day.
     *
     * @param Carbon\Carbon $date The date for which to calculate the income.
     *
     * @return float The total income for the given day.
     *               The income is calculated by summing the 'trans_amount' field of all transactions
     *               that were created on the given date.
     */
    protected function calculateIncomeForDay($date)
    {
        $sum = Transaction::whereDate('created_at', $date)
            ->where('created_at', '<=', $date->endOfDay())
            ->sum('trans_amount');
        return $sum;
    }
    /**
     * Calculates the total expense for a specific day.
     *
     * @param Carbon\Carbon $date The date for which to calculate the expense.
     *
     * @return float The total expense for the given day.
     *               The expense is calculated by summing the 'trans_amount' field of all transactions
     *               that were created on the given date.
     */
    protected function calculateExpenseForDay($date)
    {
        $sum = Expense::whereDate('created_at', $date)
            ->where('created_at', '<=', $date->endOfDay())
            ->sum('amount');
        return $sum;
    }
    public function render()
    {
        return view('livewire.admins.dashboard.earnings-report');
    }
}
