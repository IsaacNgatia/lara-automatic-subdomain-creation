<?php

namespace App\Livewire\Admins\Dashboard;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SubscriptionChart extends Component
{
    public $months;
    public $subscriptions;
    public $total;
    public function mount()
    {
        for ($m = 1; $m <= 12; $m++) {
            $this->months[] = [
                'id' => $m,
                'name' => Carbon::create()->month($m)->format('F')
            ];
        }
        $this->subscriptions = $this->getMonthlyTransactionSums() ?? array();
    }
    public function getMonthlyTransactionSums()
    {
        // Initialize an array with all months (1 to 12) set to 0
        $monthlySums = array_fill(1, 12, 0);

        // Get actual sums from the database
        $results = Transaction::selectRaw('MONTH(created_at) as month, SUM(trans_amount) as total_amount')
            ->whereYear('created_at', now()->year) // Filter for the current year
            ->groupBy(DB::raw('MONTH(created_at)')) // Group by month
            ->get();


        // Merge actual sums with the default array
        foreach ($results as $result) {
            $monthlySums[$result->month] = (float) $result->total_amount; // Use float for numeric precision
            $this->total += $result->total_amount; // Update the total sum for the chart
        }

        return array_values($monthlySums); // Return as a simple indexed array
    }
    public function render()
    {
        return view('livewire.admins.dashboard.subscription-chart');
    }
}
