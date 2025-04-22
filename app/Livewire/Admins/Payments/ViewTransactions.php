<?php

namespace App\Livewire\Admins\Payments;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ViewTransactions extends Component
{
    use WithPagination;

    // Filtering properties
    public $perPage;
    public $search;
    public $totalTransactions;

    // Specific filter parameters
    #[Url()]
    public $start_date;
    #[Url()]
    public $end_date;
    #[Url()]
    public $trans_type;
    #[Url()]
    public $payment_gateway;
    #[Url()]
    public $min_amount;
    #[Url()]
    public $max_amount;

    public $stkModalIsOpen;

    // Sorting
    public $sortField = 'id';
    public $sortDirection = 'desc';

    public function mount()
    {

        $this->perPage = 10;
        $this->totalTransactions = DB::table('transactions')->count();
        $this->stkModalIsOpen = false;
    }
    public function openStkModal()
    {
        $this->stkModalIsOpen = true;
        $this->dispatch('open-modal');
    }
    // Reset pagination when filters change
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingStartDate()
    {
        $this->resetPage();
    }
    public function updatingEndDate()
    {
        $this->resetPage();
    }
    public function updatingTransType()
    {
        $this->resetPage();
    }
    public function updatingPaymentGateway()
    {
        $this->resetPage();
    }
    public function updatingMinAmount()
    {
        $this->resetPage();
    }
    public function updatingMaxAmount()
    {
        $this->resetPage();
    }

    // Sorting method
    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? ($this->sortDirection === 'asc' ? 'desc' : 'asc')
            : 'asc';
        $this->sortField = $field;
    }

    // Reset all filters
    public function resetFilters()
    {
        $this->reset([
            'search',
            'startDate',
            'endDate',
            'transType',
            'paymentGateway',
            'minAmount',
            'maxAmount',
            'sortField',
            'sortDirection'
        ]);
        $this->resetPage();
    }

    public function render()
    {
        // Start with base query
        $query = Transaction::query();

        // Global search across multiple fields
        if ($this->search) {
            $query->where(function ($q) {
                $searchTerm = '%' . $this->search . '%';
                $q->where('trans_amount', 'like', $searchTerm)
                    ->orWhere('short_code', 'like', $searchTerm)
                    ->orWhere('reference_number', 'like', $searchTerm)
                    ->orWhere('trans_id', 'like', $searchTerm)
                    ->orWhere('first_name', 'like', $searchTerm)
                    ->orWhere('middle_name', 'like', $searchTerm)
                    ->orWhere('last_name', 'like', $searchTerm)
                    ->orWhere('trans_type', 'like', $searchTerm)
                    ->orWhere('payment_gateway', 'like', $searchTerm);
            });
        }

        // Date range filter
        if (!empty($this->start_date)) {
            $query->whereDate(
                'trans_time',
                '>=',
                Carbon::createFromFormat('Y-m-d', $this->start_date)
            );
        }

        if (!empty($this->end_date)) {
            $query->whereDate(
                'trans_time',
                '<=',
                Carbon::createFromFormat('Y-m-d', $this->end_date)
            );
        }


        // Transaction type filter
        if ($this->trans_type) {
            $query->where('trans_type', $this->trans_type);
        }

        // Payment gateway filter
        if ($this->payment_gateway) {
            $query->where('payment_gateway', $this->payment_gateway);
        }

        // Amount range filter
        if ($this->min_amount !== null) {
            $query->where('trans_amount', '>=', $this->min_amount);
        }

        if ($this->max_amount !== null) {
            $query->where('trans_amount', '<=', $this->max_amount);
        }

        // Sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        // Paginate results
        $transactions = $query->paginate($this->perPage);

        // Get distinct values for dropdowns
        $transTypes = Transaction::distinct('trans_type')->pluck('trans_type');
        $paymentGateways = Transaction::distinct('payment_gateway')->pluck('payment_gateway');

        return view('livewire.admins.payments.view-transactions', [
            'transactions' => $transactions,
            'transTypes' => $transTypes,
            'paymentGateways' => $paymentGateways,
            'totalTransactions' => $this->totalTransactions
        ]);
    }
}
