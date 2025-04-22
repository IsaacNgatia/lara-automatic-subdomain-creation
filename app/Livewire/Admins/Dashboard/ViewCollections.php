<?php

namespace App\Livewire\Admins\Dashboard;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ViewCollections extends Component
{
    public $todaysCollections;
    public $yesterCollections;
    public $monthCollections;
    public $previousMonthCollections;
    public $yearCollections;
    public $previousYearCollections;
    public $firstDateOfCurrentMonth;
    public $lastDateOfCurrentMonth;
    public $firstDateOfCurrentYear;
    public $lastDateOfCurrentYear;
    public $currentDate;
    public function mount()
    {
        $this->firstDateOfCurrentMonth = Carbon::now()->startOfMonth()->toDateString();
        $this->lastDateOfCurrentMonth = Carbon::now()->endOfMonth()->toDateString();
        $this->firstDateOfCurrentYear = Carbon::now()->startOfYear()->toDateString();
        $this->lastDateOfCurrentYear = Carbon::now()->endOfYear()->toDateString();
        $this->currentDate = Carbon::now()->toDateString();

        $this->todaysCollections = (float) DB::table('transactions')
            ->whereDate('trans_time', now()->format('Y-m-d'))
            ->sum('trans_amount');
        $this->yesterCollections = (float) DB::table('transactions')
            ->whereDate('trans_time', now()->subDay()->format('Y-m-d'))
            ->sum('trans_amount');
        $this->monthCollections = (float) DB::table('transactions')
            ->whereMonth('trans_time', now()->format('m'))
            ->whereYear('trans_time', now()->format('Y'))
            ->sum('trans_amount');
        $this->previousMonthCollections = (float) DB::table('transactions')
            ->whereMonth('trans_time', now()->subMonth()->format('m'))
            ->whereYear('trans_time', now()->subMonth()->format('Y'))
            ->sum('trans_amount');
        $this->yearCollections = (float) DB::table('transactions')
            ->whereYear('trans_time', now()->format('Y'))
            ->sum('trans_amount');
        $this->previousYearCollections = (float) DB::table('transactions')
            ->whereYear('trans_time', now()->subYear()->format('Y'))
            ->sum('trans_amount');
    }
    public function render()
    {
        return view('livewire.admins.dashboard.view-collections');
    }
}
