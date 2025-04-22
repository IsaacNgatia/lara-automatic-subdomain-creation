<?php

namespace App\Livewire\Admins\Hotspot\Cash;

use App\Models\HotspotCash;
use App\Models\Mikrotik;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CashVouchers extends Component
{
    use WithPagination;
    public $selectedCashVouchers = [];
    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $totalCashVouchers;
    public $selectedCashVoucher;
    public $markAsSoldId;
    public $deletingId;

    public function mount()
    {
        $this->totalCashVouchers = HotspotCash::count();
    }
    public function markAsSold($id)
    {
        $this->markAsSoldId = $id;
        $this->dispatch('open-modal');
    }
    public function warn($id)
    {
        $this->deletingId = $id;
        $this->dispatch('open-modal');
    }

    #[On('close-modal')]
    public function closeModal()
    {
        $this->markAsSoldId = null;
        $this->deletingId = null;
    }
    #[On('delete-cash-voucher')]
    public function deleteEpayVoucher()
    {
        $cashVoucher = HotspotCash::find($this->deletingId);
        $mikrotikResponse = Mikrotik::deleteHotspotVoucher(
            $cashVoucher->name,
            $cashVoucher->mikrotik_id
        );
        if ($mikrotikResponse === true) {
            $cashVoucher->delete();
            $this->dispatch('cash-voucher-activity-complete');
            $this->dispatch('cash-grouped-activity-complete');
        }
    }

    #[On('cancel-delete-epay-voucher')]
    public function cancelDeleteHspVoucher()
    {
        $this->dispatch('close-modal');
        $this->deletingId = null;
    }
    #[On('cash-voucher-activity-complete')]
    public function cashVoucherActivityComplete()
    {
        $this->dispatch('close-modal');
        $this->deletingId = null;
        $this->markAsSoldId = null;
    }

    function formatDataLimit(float $bytes): string
    {
        if ($bytes <= 0) {
            return "Unlimited";
        }

        $units = ["B", "KB", "MB", "GB", "TB", "PB"];
        $index = 0;

        while ($bytes >= 1024 && $index < count($units) - 1) {
            $bytes /= 1024;
            $index++;
        }


        return round($bytes, 2) . ' ' . $units[$index];
    }

    function formatTimeLimit($seconds)
    {
        if ($seconds == 0) {
            return 'Unlimited';
        }

        $units = [
            'year' => 31536000, // 365 days
            'month' => 2592000,  // 30 days
            'week' => 604800,    // 7 days
            'day' => 86400,
            'hour' => 3600,
            'minute' => 60,
            'second' => 1
        ];

        foreach ($units as $unit => $value) {
            if ($seconds >= $value) {
                $count = floor($seconds / $value);
                return $count . ' ' . $unit . ($count > 1 ? 's' : ''); // Add 's' for plural
            }
        }

        return '0 seconds';
    }
    public function render()
    {
        $cashVouchers = HotspotCash::query()
            ->where('username', 'like', '%' . $this->search . '%')
            ->orWhere('password', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
        return view('livewire.admins.hotspot.cash.cash-vouchers', ['cashVouchers' => $cashVouchers]);
    }
}
