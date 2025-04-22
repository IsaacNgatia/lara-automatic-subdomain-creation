<?php

namespace App\Livewire\Admins\Hotspot\Epay\Modals;

use App\Models\EpayPackage;
use App\Models\Mikrotik;
use InvalidArgumentException;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditEpayPackage extends Component
{
    public $servers = [];
    public $userProfiles = [];
    #[Validate('required')]
    public $dataLimitUnit;
    #[Validate('required')]
    public $timeLimitUnit;
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
    #[Validate('required|integer')]
    public $dataLimitValue;
    #[Validate('required|integer|min:1')]
    public $timeLimitValue;
    #[Validate('required|integer|min:1')]
    public $price;
    public $routerId;
    public $selectedId;

    public $epayPackage;

    public $checkingStatus = true;
    // Details from mikrotik
    public $routerStatus = false;

    public function mount($epayPackageId)
    {
        $this->selectedId = $epayPackageId;
        $selectedEpayPackage = EpayPackage::find($epayPackageId);

        $this->servers =  [['.id' => 1, 'name' => $selectedEpayPackage->server]];
        $this->userProfiles = [['.id' => 1, 'name' => $selectedEpayPackage->profile]];
        $this->routerId = $selectedEpayPackage->mikrotik_id;
        $this->title = $selectedEpayPackage->title;
        $this->price = $selectedEpayPackage->price;
        $this->setDataLimitFromBytes($selectedEpayPackage->data_limit ?? 0);
        $this->setTimeLimitFromSeconds($selectedEpayPackage->time_limit);
        $this->lengthSelected = $selectedEpayPackage->voucher_length;
        $this->passwordStatus = $selectedEpayPackage->password_status;
        $this->serverSelected = $selectedEpayPackage->server;
        $this->profileSelected = $selectedEpayPackage->profile;

        $this->epayPackage = $selectedEpayPackage;
    }
    public function setDataLimitFromBytes(float $bytes): void
    {
        if ($bytes <= 0) {
            $this->dataLimitUnit = 'GBs';
            $this->dataLimitValue = 0;
            return;
        }

        $units = ['B', 'KBs', 'MBs', 'GBs', 'TBs', 'PBs'];
        $index = 0;

        while ($bytes >= 1024 && $index < count($units) - 1) {
            $bytes /= 1024;
            $index++;
        }

        $this->dataLimitValue = round($bytes, 2);
        $this->dataLimitUnit = $units[$index];
        return;
    }
    public function setTimeLimitFromSeconds(int $seconds): void
    {
        if ($seconds <= 0) {
            $this->timeLimitValue = null;
            $this->timeLimitUnit = null;
            return;
        }

        if ($seconds >= 2592000) { // 30 days
            $this->timeLimitValue = round($seconds / 2592000, 2);
            $this->timeLimitUnit = 'months';
        } elseif ($seconds >= 604800) { // 7 days
            $this->timeLimitValue = round($seconds / 604800, 2);
            $this->timeLimitUnit = 'weeks';
        } elseif ($seconds >= 86400) { // 1 day
            $this->timeLimitValue = round($seconds / 86400, 2);
            $this->timeLimitUnit = 'days';
        } elseif ($seconds >= 3600) { // 1 hour
            $this->timeLimitValue = round($seconds / 3600, 2);
            $this->timeLimitUnit = 'hours';
        } elseif ($seconds >= 60) {
            $this->timeLimitValue = round($seconds / 60, 2);
            $this->timeLimitUnit = 'minutes';
        } else {
            $this->timeLimitValue = $seconds;
            $this->timeLimitUnit = 'seconds';
        }
    }
    #[On('checkout-status')]
    public function checkRouterStatus()
    {
        // $this->checkingStatus = true;
        $connect = Mikrotik::getLoginCredentials($this->routerId);
        $mikrotikResponse = Mikrotik::fetchHspDetails($connect);
        if ($mikrotikResponse && isset($mikrotikResponse['servers']) && isset($mikrotikResponse['user-profiles'])) {
            $this->routerStatus = true;
            $this->servers = $mikrotikResponse['servers'];
            $this->userProfiles = $mikrotikResponse['user-profiles'];
            $this->checkingStatus = false;
            $this->render();
            return true;
        } else {
            $this->checkingStatus = false;
            return false;
        }
    }
    public function updateEpayPackage()
    {
        $this->validate();
        try {

            $dataLimit = $this->convertToBytes($this->dataLimitUnit, $this->dataLimitValue);
            $timeLimit = $this->convertToSeconds($this->timeLimitUnit, $this->timeLimitValue);

            if ($this->epayPackage) {
                $updateData = [
                    'title' => $this->title,
                    'price' => $this->price,
                    'data_limit' => $dataLimit,
                    'time_limit' => $timeLimit,
                    'voucher_length' => $this->lengthSelected,
                    'password_status' => $this->passwordStatus,
                    'updated_at' => now(env('APP_TIMEZONE', 'Africa/Nairobi')),

                ];
                if ($this->routerStatus) {
                    $updateData['server'] = $this->serverSelected;
                    $updateData['profile'] = $this->profileSelected;
                }
                $this->epayPackage->update($updateData);
                session()->flash('success', 'Hotspot Package updated successfully');
                $this->dispatch('epay-package-activity-complete');
            } else {
                session()->flash('resultError', 'Failed to update the package. Please try again.');
            }
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('resultError', $th->getMessage());
        }
    }
    private function convertToBytes(string $unit, float $value): float|string|null
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
    private function convertToSeconds($unit, $value)
    {
        switch ($unit) {
            case 'months':
                return $value * 2592000; // 30 days
            case 'weeks':
                return $value * 604800; // 7 days
            case 'days':
                return $value * 86400;
            case 'hours':
                return $value * 3600;
            case 'minutes':
                return $value * 60;
            default:
                return $value; // Default to seconds
        }
    }
    public function render()
    {
        return view('livewire.admins.hotspot.epay.modals.edit-epay-package');
    }
}
