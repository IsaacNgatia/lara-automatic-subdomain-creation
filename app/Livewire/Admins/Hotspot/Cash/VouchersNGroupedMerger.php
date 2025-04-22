<?php

namespace App\Livewire\Admins\Hotspot\Cash;

use App\Models\HotspotCash;
use Livewire\Attributes\On;
use Livewire\Component;

class VouchersNGroupedMerger extends Component
{
    public $markAsSoldId;
    public $deletingId;

    #[On('mark-cash-voucher-as-sold')]
    public function markAsSold($id)
    {
        $this->markAsSoldId = $id;
        $this->dispatch('open-modal');
    }
    #[On('close-modal')]
    public function closeModal()
    {
        $this->markAsSoldId = null;
        $this->deletingId = null;
        $this->dispatch('close-modal');
    }
    public function render()
    {
        return view('livewire.admins.hotspot.cash.vouchers-n-grouped-merger');
    }
}
