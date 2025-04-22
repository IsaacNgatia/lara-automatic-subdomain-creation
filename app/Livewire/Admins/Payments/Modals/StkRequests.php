<?php

namespace App\Livewire\Admins\Payments\Modals;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use App\Models\Callback;

class StkRequests extends Component
{
    use WithPagination;

    public $perPage;
    public $search;
    public $totalstkRequests;

    // Sorting
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public function mount()
    {
        $this->perPage = 10;
        $this->totalstkRequests = Callback::count();
    }
    /**
     * Toggle sorting direction when sorting by a field.
     */
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    public function render()
    {
        $search = $this->search;
        $stkRequests = Callback::query()
            ->select('id', 'merchant_request_id', 'trans_id', 'amount', 'phone', 'status', 'trans_timestamp', 'created_at')
            ->where(function ($query) use ($search) {
                $query->where('merchant_request_id', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('trans_id', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('trans_timestamp', 'like', "%{$search}%")
                    ->orWhere('created_at', 'like', "%{$search}%");
            })
            ->orderBy($this->sortField, $this->sortDirection) // Sorting applied
            ->paginate($this->perPage);
        return view('livewire.admins.payments.modals.stk-requests', ['stkRequests' => $stkRequests]);
    }
}
