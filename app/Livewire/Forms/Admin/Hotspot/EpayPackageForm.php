<?php

namespace App\Livewire\Forms\hotspot;

use App\Models\HotspotVoucher;
use App\Models\Mikrotik;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EpayPackageForm extends Form
{
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
    #[Validate('required')]
    public $title;
    public $routerId;

    public function create()
    {
        try {

            $seconds = $this->calculateTimeLimit($this->timelimit, $this->timelimitValue);
            $limitBytesOut = $this->calculateDataLimit($this->datalimit, $this->datalimitValue);
            // $connect = Mikrotik::getLoginCredentials($this->routerId);
            $connect = [
                'ip' => '47.237.106.106',
                'port' => '1000',
                'user' => 'ISPKenya',
                'password' => 'Password@2022.'
            ];
            $result = Mikrotik::createEpayVouchers($connect, [
                'timelimit' => $seconds,
                'datalimit' => $limitBytesOut,
                'profile' => $this->profile,
                'server' => $this->server,
                'length' => $this->voucherLength,
                'password-status' => $this->passwordStatus,
                'price' => $this->price,
                'packageName' => $this->title,
                'mikrotik-id' => '1'
            ]);
            return $result;
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
    private function calculateDataLimit(string $bandwidth, int $datalimit)
    {
        $conversionFactors = [
            "GBs" => 1000000000, // or 134217728
            "MBs" => 1000000, // or 1048576
            "KBs" => 1000, // or 1024
        ];

        $limitBytesOut = $datalimit != 0 && isset($conversionFactors[$bandwidth])
            ? $datalimit * $conversionFactors[$bandwidth]
            : $datalimit;
        return $limitBytesOut;
    }
}
