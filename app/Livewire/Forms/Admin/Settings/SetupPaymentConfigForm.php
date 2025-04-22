<?php

namespace App\Livewire\Forms\Admin\Settings;

use App\Models\PaymentConfig;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SetupPaymentConfigForm extends Form
{
    //
    public $gatewayConfig;
    public $shortCode;
    public $clientSecret;
    public $clientKey;
    public $passKey;
    public $storeNo;
    public $tillNo;
    public $mobileNo;
    public $companyName;
    public $gatewayId;
    public $configId;
    public function save()
    {
        try {
            $keys = [
                'pass_key',
                'client_secret',
                'client_key',
                'client_id',
                'short_code',
                'store_no',
                'till_no',
                'company_name',
            ];
            $configArray = [];
            foreach ($keys as $key) {
                $configArray[$key] = $this->gatewayConfig[$key] ?? null;
            }
            $missingDetails = [];
            foreach ($configArray as $key => $value) {
                if ($value === 1) {
                    switch ($key) {
                        case 'pass_key':
                            if (empty($this->passKey)) {
                                $missingDetails[] = 'Pass Key';
                            }
                            break;
                        case 'client_secret':
                            if (empty($this->clientSecret)) {
                                $missingDetails[] = 'Client Secret';
                            }
                            break;
                        case 'client_key':
                            if (empty($this->clientKey)) {
                                $missingDetails[] = 'Client Key';
                            }
                            break;
                        case 'client_id':
                            if (empty($this->clientKey)) {
                                $missingDetails[] = 'Client Id';
                            }
                            break;
                        case 'short_code':
                            if (empty($this->shortCode)) {
                                $missingDetails[] = $this->gatewayId == '1' ? 'Paybill' : 'House Number';
                            }
                            break;
                        case 'store_no':
                            if (empty($this->storeNo)) {
                                $missingDetails[] = 'Store Number';
                            }
                            break;
                        case 'till_no':
                            if (empty($this->tillNo)) {
                                $missingDetails[] = 'Till Number';
                            }
                            break;
                        case 'company_name':
                            if (empty($this->companyName)) {
                                $missingDetails[] = 'Company Name';
                            }
                            break;
                    }
                }
            }
            if (!empty($missingDetails)) {
                return 'Missing required information: ' . implode(', ', $missingDetails);
            }
            $store = PaymentConfig::create([
                'payment_gateway_id' => $this->gatewayId,
                'pass_key' => $this->passKey,
                'client_secret' => $this->clientSecret,
                'client_key' => $this->clientKey,
                'short_code' => $this->shortCode,
                'store_no' => $this->storeNo,
                'till_no' => $this->tillNo,
                'company_name' => $this->companyName,
            ]);
            $this->configId = $store->id;
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }
}
