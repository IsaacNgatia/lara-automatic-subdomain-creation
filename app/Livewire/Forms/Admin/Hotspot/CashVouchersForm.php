<?php

namespace App\Livewire\Forms\Admin\Hotspot;

use App\Models\HotspotCash;
use App\Models\Mikrotik;
use InvalidArgumentException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CashVouchersForm extends Form
{
    #[Validate('required|integer|max:100')]
    public $quantity;
    #[Validate('required')]
    public $passwordStatus;
    #[Validate('required')]
    public $server;
    #[Validate('required')]
    public $profile;
    #[Validate('required')]
    public $datalimit;
    #[Validate('required')]
    public $datalimitValue;
    #[Validate('required')]
    public $timelimit;
    #[Validate('required')]
    public $timelimitValue;
    #[Validate('required')]
    public $voucherLength;
    #[Validate('required')]
    public $price;
    public $routerId;

    public function create()
    {
        try {

            $seconds = $this->calculateTimeLimit($this->timelimit, $this->timelimitValue);
            $limitBytesOut = $this->convertToBytes($this->datalimit, $this->datalimitValue);

            return HotspotCash::addVouchers([
                'timelimit' => $seconds,
                'datalimit' => $limitBytesOut,
                'quantity' => $this->quantity,
                'profile' => $this->profile,
                'server' => $this->server,
                'length' => $this->voucherLength,
                'password-status' => $this->passwordStatus,
                'price' => $this->price,
                'mikrotik-id' => $this->routerId,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }
    private function calculateTimelimit(string $duration, int $timelimit)
    {
        $conversionFactors = [
            "minutes" => 60,
            "hours" => 3600,
            "days" => 86400, // 24 * 3600
            "weeks" => 604800, // 7 * 24 * 3600
            "months" => 2592000, // 30 * 24 * 3600
        ];

        $seconds = $timelimit * ($conversionFactors[$duration] ?? 1);
        return $seconds;
    }
    function convertToBytes(string $unit, float $value): float|string|null
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
}
