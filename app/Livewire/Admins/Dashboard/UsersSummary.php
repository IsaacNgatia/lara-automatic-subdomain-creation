<?php

namespace App\Livewire\Admins\Dashboard;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;


class UsersSummary extends Component
{
    public $totalUsers;
    public $inactiveUsers;
    public $activeUsers;
    public $currentSumSubscription;
    public $previousSumSubscription;
    /**
     * Mounts the component and calculates the total, inactive, and active users.
     *
     * @return void
     */
    public function mount()
    {
        // Calculate the total number of users
        $this->totalUsers = DB::table('customers')->count();

        // Calculate the number of inactive users
        $this->inactiveUsers = DB::table('customers')
            ->where(function ($query) {
                $query->where('grace_date', '<', now(env('APP_TIMEZONE', 'Africa/Nairobi')))
                    ->orWhereNull('grace_date')
                    ->where('expiry_date', '<', now(env('APP_TIMEZONE', 'Africa/Nairobi')));
            })
            ->count();

        // Calculate the number of active users
        $this->activeUsers = DB::table('customers')
            ->where(function ($query) {
                $query->where('grace_date', '>', now(env('APP_TIMEZONE', 'Africa/Nairobi')))
                    ->orWhereNull('grace_date')
                    ->where('expiry_date', '>', now(env('APP_TIMEZONE', 'Africa/Nairobi')));
            })
            ->count();
        $this->currentSumSubscription = $this->getCurrentMonthTotal();
        $this->previousSumSubscription = $this->getPreviousMonthTotal();
    }
    function getCurrentMonthTotal()
    {
        return DB::table('transactions')
            ->whereMonth('created_at', Carbon::now(env('APP_TIMEZONE', 'Africa/Nairobi'))->month)
            ->whereYear('created_at', Carbon::now(env('APP_TIMEZONE', 'Africa/Nairobi'))->year)
            ->sum('trans_amount');
    }
    function getPreviousMonthTotal()
    {
        $previousMonth = Carbon::now(env('APP_TIMEZONE', 'Africa/Nairobi'))->subMonth();
        return DB::table('transactions')
            ->whereMonth('created_at', $previousMonth->month)
            ->whereYear('created_at', $previousMonth->year)
            ->sum('trans_amount');
    }
    public function render()
    {
        return view('livewire.admins.dashboard.users-summary');
    }
}
