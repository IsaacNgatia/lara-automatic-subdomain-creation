<?php

namespace App\Livewire\Forms\Admin\Settings;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\SmsConfig;


class SetupSmsConfigForm extends Form
{
    public $providerConfig = [];
    #[Validate("required_if:providerConfig.api_key,!=,'',providerConfig.api_key")]
    public $apiKey;
    #[Validate("required_if:providerConfig.api_secret,!=,'',providerConfig.api_secret")]
    public $apiSecret;
    #[Validate("required_if:providerConfig.sender_id,!=,'',providerConfig.sender_id")]
    public $senderId;
    #[Validate("required_if:providerConfig.username,!=,'',providerConfig.username")]
    public $username;
    #[Validate("required_if:providerConfig.password,!=,'',providerConfig.password")]
    public $password;
    #[Validate("required_if:providerConfig.short_code,!=,'',providerConfig.short_code")]
    public $shortCode;
    #[Validate("required_if:providerConfig.output_type,!=,'',providerConfig.output_type")]
    public $outputType;
    // #[Validate("boolean")]
    public $isDefault = 1;
    #[Validate("required")]
    public $providerId;
    public $configId;

    public function store()
    {
        try {
            $this->validate();
            $keys = [
                'api_key',
                'sender_id',
                'username',
                'password',
                'short_code',
                'api_secret',
                '_all',
            ];
            $configArray = [];
            foreach ($keys as $key) {
                $configArray[$key] = $this->providerConfig[$key] ?? null;
            }
            $missingDetails = [];
            foreach ($configArray as $key => $value) {
                if ($value === 1) {
                    switch ($key) {
                        case 'api_key':
                            if (empty($this->apiKey)) {
                                $missingDetails[] = 'API Key';
                            }
                            break;
                        case 'sender_id':
                            if (empty($this->senderId)) {
                                $missingDetails[] = 'Sender ID';
                            }
                            break;
                        case 'username':
                            if (empty($this->username)) {
                                $missingDetails[] = 'Username';
                            }
                            break;
                        case 'password':
                            if (empty($this->password)) {
                                $missingDetails[] = 'Password';
                            }
                            break;
                        case 'short_code':
                            if (empty($this->shortCode)) {
                                $missingDetails[] = 'Short Code';
                            }
                            break;
                        case 'api_secret':
                            if (empty($this->apiSecret)) {
                                $missingDetails[] = 'API Secret';
                            }
                            break;
                        case '_all':
                            if (empty($this->apiKey) || empty($this->senderId) || empty($this->username) || empty($this->password) || empty($this->shortCode) || empty($this->apiSecret)) {
                                $missingDetails[] = 'All required fields';
                            }
                            break;
                    }
                }
            }
            if (!empty($missingDetails)) {
                return 'Missing required information: ' . implode(', ', $missingDetails);
            }
            $smsConfig = SmsConfig::create([
                "sms_provider_id" => $this->providerId,
                "api_key" => $this->apiKey,
                "api_secret" => $this->apiSecret,
                "sender_id" => $this->senderId,
                "username" => $this->username,
                "password" => $this->password,
                "short_code" => $this->shortCode,
                "is_default" => $this->isDefault,
                "output_type" => $this->outputType,
            ]);
            $this->configId = $smsConfig->id;
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }
    }
}
