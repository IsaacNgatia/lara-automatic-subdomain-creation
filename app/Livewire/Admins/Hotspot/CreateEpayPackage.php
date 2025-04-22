<?php

namespace App\Livewire\Admins\Hotspot;

use App\Models\EpayPackage;
use App\Models\ServicePlan;
use InvalidArgumentException;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateEpayPackage extends Component
{
    public $servers;
    public $userProfiles;
    #[Validate('required')]
    public $dataLimitSelected;
    #[Validate('required')]
    public $timeLimitSelected;
    #[Validate('required')]
    public $lengthSelected;
    #[Validate('required')]
    public $passwordStatus;
    #[Validate('required')]
    public $serverSelected;
    #[Validate('required')]
    public $profileSelected;
    #[Validate('required')]
    public $title;
    #[Validate('required|integer|min:1')]
    public $dataLimitValue;
    #[Validate('required|integer|min:1')]
    public $timeLimitValue;
    #[Validate('required|integer|min:1')]
    public $price;
    public $routerId;

    public function mount($servers, $userProfiles, $routerId)
    {
        $this->servers = $servers;
        $this->userProfiles = $userProfiles;
        $this->routerId = $routerId;
        $this->dataLimitSelected = 'GBs';
        $this->timeLimitSelected = 'hours';
        $this->lengthSelected = '6';
        $this->passwordStatus = 1;
    }
    public function createEpayPackage()
    {
        $this->validate();
        $seconds = $this->convertToSeconds($this->timeLimitSelected, $this->timeLimitValue);
        if (is_array($seconds) && $seconds['error']) {
            $this->addError('timeLimitValue', $seconds['message']);
            return;
        }
        // Convert data limit to MBs
        $dataLimit = $this->convertToMBs($this->dataLimitSelected, $this->dataLimitValue);

        // Check if an identical package already exists
        $exists = EpayPackage::where([
            'title' => $this->title,
            'server' => $this->serverSelected,
            'profile' => $this->profileSelected,
            'data_limit' => $dataLimit,
            'time_limit' => $seconds,
            'price' => $this->price,
            'password_status' => $this->passwordStatus,
            'voucher_length' => $this->lengthSelected,
            'mikrotik_id' => $this->routerId,
        ])->exists();

        if ($exists) {
            session()->flash('resultError', 'A similar Hotspot Package already exists.');
            return;
        }

        $result = EpayPackage::create([
            'title' => $this->title,
            'server' => $this->serverSelected,
            'profile' => $this->profileSelected,
            'data_limit' => $dataLimit,
            'time_limit' => $seconds,
            'price' => $this->price,
            'password_status' => $this->passwordStatus,
            'voucher_length' => $this->lengthSelected,
            'mikrotik_id' => $this->routerId
        ]);
        if ($result == true) {
            $this->reset(['title', 'price', 'dataLimitValue', 'timeLimitValue']);
            $this->render();
            session()->flash('success', ' Hotspot Package created successfully');
        } else {
            session()->flash('resultError', $result);
        }
    }
    function convertToMBs(string $unit, float $value): float|string|null
    {
        if ($value == 0) {
            return null;
        }

        $unit = strtolower($unit); // Convert to lowercase for consistency

        switch ($unit) {
            case 'pbs':
                return $value * 1073741824 * 1024 * 1024;
            case 'tbs':
                return $value * 1073741824 * 1024;
            case 'gbs':
                return $value * 1073741824;
            case 'mbs':
                return $value * 1048576;
            case 'kbs':
                return $value * 1024;
            default:
                throw new InvalidArgumentException("Invalid unit: $unit. Allowed units are GBs, MBs, and KBs.");
        }
    }
    function convertToSeconds(string $unit, float $value): float|string|array
    {
        if ($value == 0) {
            return ['error' => true, 'message' => 'cannot accept 0 as timelimit'];
        }

        $unit = strtolower($unit); // Convert to lowercase for consistency

        switch ($unit) {
            case 'seconds':
                return $value;
            case 'minutes':
                return $value * 60; // 1 minute = 60 seconds
            case 'hours':
                return $value * 60 * 60; // 1 hour = 3600 seconds
            case 'days':
                return $value * 24 * 60 * 60; // 1 day = 86400 seconds
            case 'weeks':
                return $value * 7 * 24 * 60 * 60; // 1 week = 604800 seconds
            case 'months':
                return $value * 30 * 24 * 60 * 60; // Approximate: 1 month = 30 days
            case 'years':
                return $value * 365 * 24 * 60 * 60; // 1 year = 365 days
            default:
                throw new InvalidArgumentException("Invalid unit: $unit. Allowed units are seconds, minutes, hours, days, weeks, months, and years.");
        }
    }

    public function render()
    {
        return view('livewire.admins.hotspot.create-epay-package');
    }
}
