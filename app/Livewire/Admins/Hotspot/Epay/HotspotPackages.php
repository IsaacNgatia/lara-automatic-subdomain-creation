<?php

namespace App\Livewire\Admins\Hotspot\Epay;

use App\Models\EpayPackage;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class HotspotPackages extends Component
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
        $this->totalEpayPackages = EpayPackage::count();
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
        $epayPackage = EpayPackage::find($this->deletingId);
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
    public function countActiveVouchers($id)
    {
        return DB::table('hotspot_epays')->where('epay_package_id', $id)->count();
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

        return round($bytes, 2) . $units[$index];
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
        $this->epayPackages = DB::table('epay_packages')
            ->join('mikrotiks', 'epay_packages.mikrotik_id', '=', 'mikrotiks.id')
            ->select(
                'epay_packages.id',
                'epay_packages.title',
                'epay_packages.server',
                'epay_packages.password_status',
                'epay_packages.profile',
                'epay_packages.price',
                'epay_packages.voucher_length',
                'epay_packages.data_limit',
                'epay_packages.time_limit',
                'mikrotiks.name as mikrotik_identity'
            )
            ->where(function ($query) use ($search) {
                $query->where('epay_packages.title', 'like', '%' . $search . '%')
                    ->orWhere('epay_packages.server', 'like', '%' . $search . '%')
                    ->orWhere('epay_packages.profile', 'like', '%' . $search . '%')
                    ->orWhere('epay_packages.price', 'like', '%' . $search . '%')
                    ->orWhere('mikrotiks.name', 'like', '%' . $search . '%');
            })->paginate($this->perPage);
        return view('livewire.admins.hotspot.epay.hotspot-packages', [
            'epayPackages' => $this->epayPackages,
        ]);
    }
}
