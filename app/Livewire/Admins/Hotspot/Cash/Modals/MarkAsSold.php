<?php

namespace App\Livewire\Admins\Hotspot\Cash\Modals;

use App\Models\HotspotCash;
use Livewire\Attributes\Validate;
use Livewire\Component;

class MarkAsSold extends Component
{
    public $voucherId;
    public $voucher;
    public $timeLimit;
    public $dataLimit;
    public $username;
    public $password;
    public $price;

    #[Validate('required|numeric')]
    public $phone;
    public function mount($id)
    {
        $this->voucherId = $id;
        $this->voucher = HotspotCash::find($this->voucherId);

        $voucher = HotspotCash::find($id);
        if (!$voucher) {
            $this->dispatch('close-modal');
            return;
        }
        $this->timeLimit = $this->formatTimeLimit($voucher->time_limit);
        $this->dataLimit = $voucher->data_limit ? $this->formatDataLimit($voucher->data_limit) : 'Unlimited';
        $this->username = $voucher->username;
        $this->password = $voucher->password;
        $this->price = $voucher->price;
    }
    public function markAsSold()
    {
        $this->validate();
        try {
            if (HotspotCash::markAsSold($this->voucherId, $this->phone) === true) {
                session()->flash('success', 'Voucher marked as sold successfully');
                $this->dispatch('close-modal');
            }
        } catch (\Throwable $th) {
            session()->flash('resultError', 'Error marking voucher as sold: ' . $th->getMessage());
        }
    }
    private function formatDataLimit(float $bytes): string
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

    private function formatTimeLimit($seconds)
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
        return view('livewire.admins.hotspot.cash.modals.mark-as-sold');
    }
}
