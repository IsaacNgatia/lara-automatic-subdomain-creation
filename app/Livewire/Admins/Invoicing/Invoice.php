<?php

namespace App\Livewire\Admins\Invoicing;

use App\Models\Invoice as ModelsInvoice;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

class Invoice extends Component
{

    public $search;

    public function render()
    {
        $invoices = ModelsInvoice::query()
            ->orderByDesc('id')
            ->when(
                ! empty($this->search),
                fn(Builder $q) => $q->where('reference_number', 'like', "%{$this->search}%")
            )
            ->paginate(10);

        return view('livewire.admins.invoicing.invoice', [
            'invoices' => $invoices
        ]);
    }
}
