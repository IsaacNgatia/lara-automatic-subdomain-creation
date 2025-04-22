<?php

namespace App\Livewire\Admins\Hotspot\Epay;

use App\Models\HotspotEpay;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class HotspotVouchers extends Component
{
    use WithPagination;
    private $epayPackages;
    public $perPage;
    public $search;
    public $totalEpayPackages;
    public $updatingId;
    public $deletingId;
    public function mount()
    {
        $this->perPage = 10;
        $this->totalEpayPackages = HotspotEpay::count();
    }
    public function editEpayPackage($id)
    {
        $this->updatingId = $id;
        $this->dispatch('open-modal');
    }
    public function warn($id)
    {
        $this->deletingId = $id;
        $this->dispatch('open-modal');
    }
    #[On('cancel-update-epay-package')]
    public function cancelUpdateEpayPackage()
    {
        $this->dispatch('close-modal');
        $this->updatingId = null;
    }
    #[On('delete-epay-package')]
    public function deleteEpayPackage()
    {
        $epayPackage = HotspotEpay::find($this->deletingId);
        if ($epayPackage->delete()) {
            $this->dispatch('epay-package-activity-complete');
        }
    }
    #[On('cancel-delete-epay-package')]
    public function cancelDeletePppoeUser()
    {
        $this->dispatch('close-modal');
        $this->deletingId = null;
    }
    /**
     * This function handles the completion of epay package activities.
     * It closes the modal, resets the deleting and updating IDs, and dispatches an event to indicate completion.
     *
     * @return void
     */
    #[On('epay-package-activity-complete')]
    public function epayPackageActivityComplete()
    {
        $this->dispatch('close-modal');
        $this->deletingId = null;
        $this->updatingId = null;
    }
    function formatDataLimit($sizeInMB)
    {
        if ($sizeInMB == 0) {
            return 'Unlimited';
        }

        $units = ['MB', 'GB', 'TB'];
        $unitIndex = 0;

        while ($sizeInMB >= 1024 && $unitIndex < count($units) - 1) {
            $sizeInMB /= 1024;
            $unitIndex++;
        }

        return round($sizeInMB, 2) . $units[$unitIndex];
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
        $search = $this->search;
        $this->epayPackages = DB::table('hotspot_epays')
            ->join('mikrotiks', 'hotspot_epays.mikrotik_id', '=', 'mikrotiks.id')
            ->select(
                'hotspot_epays.id',
                'hotspot_epays.name',
                'hotspot_epays.password',
                'hotspot_epays.price',
                'hotspot_epays.data_limit',
                'hotspot_epays.time_limit',
                'hotspot_epays.expiry_date',
                'mikrotiks.name as mikrotik_identity'
            )
            ->where(function ($query) use ($search) {
                $query->where('hotspot_epays.name', 'like', '%' . $search . '%')
                    ->orWhere('hotspot_epays.password', 'like', '%' . $search . '%')
                    ->orWhere('hotspot_epays.price', 'like', '%' . $search . '%')
                    ->orWhere('hotspot_epays.expiry_date', 'like', '%' . $search . '%')
                    ->orWhere('mikrotiks.name', 'like', '%' . $search . '%');
            })->paginate($this->perPage);
        return view('livewire.admins.hotspot.epay.hotspot-vouchers', [
            'epayPackages' => $this->epayPackages,
        ]);
    }
}
