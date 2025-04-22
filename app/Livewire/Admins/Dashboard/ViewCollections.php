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
        $this->firstDateOfCurrentMonth = Carbon::now(env('APP_TIMEZONE', 'Africa/Nairobi'))->startOfMonth()->toDateString();
        $this->lastDateOfCurrentMonth = Carbon::now(env('APP_TIMEZONE', 'Africa/Nairobi'))->endOfMonth()->toDateString();
        $this->firstDateOfCurrentYear = Carbon::now(env('APP_TIMEZONE', 'Africa/Nairobi'))->startOfYear()->toDateString();
        $this->lastDateOfCurrentYear = Carbon::now(env('APP_TIMEZONE', 'Africa/Nairobi'))->endOfYear()->toDateString();
        $this->currentDate = Carbon::now(env('APP_TIMEZONE', 'Africa/Nairobi'))->toDateString();

        $this->todaysCollections = (float) DB::table('transactions')
            ->whereDate('trans_time', now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('Y-m-d'))
            ->sum('trans_amount');
        $this->yesterCollections = (float) DB::table('transactions')
            ->whereDate('trans_time', now(env('APP_TIMEZONE', 'Africa/Nairobi'))->subDay()->format('Y-m-d'))
            ->sum('trans_amount');
        $this->monthCollections = (float) DB::table('transactions')
            ->whereMonth('trans_time', now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('m'))
            ->whereYear('trans_time', now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('Y'))
            ->sum('trans_amount');
        $this->previousMonthCollections = (float) DB::table('transactions')
            ->whereMonth('trans_time', now(env('APP_TIMEZONE', 'Africa/Nairobi'))->subMonth()->format('m'))
            ->whereYear('trans_time', now(env('APP_TIMEZONE', 'Africa/Nairobi'))->subMonth()->format('Y'))
            ->sum('trans_amount');
        $this->yearCollections = (float) DB::table('transactions')
            ->whereYear('trans_time', now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('Y'))
            ->sum('trans_amount');
        $this->previousYearCollections = (float) DB::table('transactions')
            ->whereYear('trans_time', now(env('APP_TIMEZONE', 'Africa/Nairobi'))->subYear()->format('Y'))
            ->sum('trans_amount');
    }
    public function render()
    {
        return view('livewire.admins.dashboard.view-collections');
    }
}
