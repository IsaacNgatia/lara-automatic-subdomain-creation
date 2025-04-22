<?php

namespace App\Livewire\Admins\Reports\Customers;

use App\Models\Customer;
use Carbon\Carbon;
use Livewire\Component;

use function Laravel\Prompts\select;

class SelectCustomers extends Component
{
    public $customers;
    public $selectedCustomers = [];
    public $userType;
    public $startingDate;
    public $endingDate;
    public $createReport;

    public function mount()
    {

        $this->userType = null;
        // Eager load relationships if necessary
        $this->customers = Customer::query()
            ->select('id', 'official_name')
            ->get();
        $this->startingDate = Carbon::now(env('APP_TIMEZONE', 'Africa/Nairobi'))->startOfMonth()->toDateTimeString();
        $this->endingDate = Carbon::now(env('APP_TIMEZONE', 'Africa/Nairobi'))->toDateTimeString();
        $this->createReport = false;
    }

    public function updatedUserType($value)
    {
        if ($value == 'all') {
            $this->selectedCustomers = Customer::all()->pluck('id')->toArray();
        } else {
            $this->selectedCustomers = $this->loadCustomers()->pluck('id')->toArray();
        }

        $this->dispatchSendToGroupEvent($this->selectedCustomers);
    }
    private function dispatchSendToGroupEvent($users): void
    {
        $this->dispatch('sendToGroup', $users);
    }
    private function loadCustomers()
    {
        return Customer::query()
            ->select('id', 'official_name')
            ->where('connection_type', $this->userType)
            ->get();
    }
    public function generateReport()
    {
        // $this->startingDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->startingDate)->format('Y-m-d\TH:i:s');
        // $this->endingDate = Carbon::createFromFormat('Y-m-d H:i:s', $this->endingDate)->format('Y-m-d\TH:i:s');
        $this->validate([
            'startingDate' => 'required|date',
            'endingDate' => 'required|date|after_or_equal:startingDate',
            'selectedCustomers' => 'required|array',
        ]);

        $this->createReport = true;
        // $this->dispatch('createReport', $this->startingDate, $this->endingDate, $this->selectedCustomers);
    }
    public function render()
    {
        return view('livewire.admins.reports.customers.select-customers');
    }
}
