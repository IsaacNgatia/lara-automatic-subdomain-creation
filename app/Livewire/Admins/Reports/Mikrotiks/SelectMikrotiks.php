<?php

namespace App\Livewire\Admins\Reports\Mikrotiks;

use App\Models\Mikrotik;
use Carbon\Carbon;
use Livewire\Component;

class SelectMikrotiks extends Component
{
    public $selectedMikrotiks = [];
    public $mikrotiks = [];
    public $startingDate;
    public $endingDate;
    public  $groupInto;

    public $createReport = false;

    public function mount()
    {
        $this->groupInto = 'none';
        $this->mikrotiks = Mikrotik::select('id', 'name')
            ->get();
        $this->startingDate = Carbon::now(env('APP_TIMEZONE', 'Africa/Nairobi'))->startOfMonth()->toDateTimeString();
        $this->endingDate = Carbon::now(env('APP_TIMEZONE', 'Africa/Nairobi'))->toDateTimeString();
    }
    public function generateReport()
    {
        $this->validate([
            'selectedMikrotiks' => 'required|array',
            'startingDate' => 'required|date',
            'endingDate' => 'required|date|after_or_equal:startingDate',
        ]);

        $this->createReport = true;
    }
    public function render()
    {
        return view('livewire.admins.reports.mikrotiks.select-mikrotiks');
    }
}
