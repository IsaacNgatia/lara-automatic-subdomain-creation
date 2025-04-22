<?php

namespace App\Livewire\Client\Dashboard;

use App\Models\Customer;
use Livewire\Component;

class PaymentTrend extends Component
{
    public $payments;
    public $customer;
    public $chartData = [];

    public function mount()
    {
        $this->customer = Customer::where('id', auth()->guard('client')->user()->id)->first();
        $this->payments = $this->customer->payments;

        // dd($this->payments);

        // Calculate monthly totals
        $monthlyTotals = collect($this->payments)
            ->groupBy(function ($transaction) {
                return date('F Y', strtotime($transaction['payment_date']));
            })
            ->map(function ($monthGroup) {
                return $monthGroup->sum('amount');
            });

            // dd($monthlyTotals->values());

        // Prepare chart data
        $this->chartData = [
            'categories' => $monthlyTotals->keys()->toArray(),
            'series' => [
                [
                    'name' => 'Amount',
                    'data' => $monthlyTotals->values()->toArray(),
                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.client.dashboard.payment-trend');
    }
}
