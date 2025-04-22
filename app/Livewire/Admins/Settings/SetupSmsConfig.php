<?php

namespace App\Livewire\Admins\Settings;

use App\Livewire\Forms\Admin\Settings\SetupSmsConfigForm;
use App\Models\Sms;
use App\Models\SmsProvider;
use Livewire\Component;

class SetupSmsConfig extends Component
{
    public $providers;
    public SetupSmsConfigForm $setupAccountForm;
    public $selectedProvider; // Property to track the selected provider
    public $providerConfig; // Property to hold the configuration for the selected provider
    public $currentStep = 1; // Track the current step index
    public $isStored;
    public $status = [];
    public $isSuccess = ['1' => false, '2' => false, '3' => false];
    public $isError = ['1' => false, '2' => false, '3' => false];
    public $phone;
    public $message;
    public function mount()
    {
        $this->providers = SmsProvider::all();
        $this->selectedProvider = null; // Initialize selected provider
        $this->providerConfig = []; // Initialize provider configuration
        $this->isStored = false;
        $this->phone = '0790008915';
        $this->message = 'Testing SMS Integration from Billing System';
    }

    public function updatedSelectedProvider($providerId)
    {
        // Fetch the configuration based on the selected provider
        $this->providerConfig = SmsProvider::find($providerId);
        $this->setupAccountForm->providerConfig = $this->providerConfig;
        $this->setupAccountForm->outputType = $this->providerConfig['output_type'];
    }
    public function goBack()
    {
        $this->currentStep--;
    }
    public function checkIndexAndCallFunction()
    {
        // Check the current step index
        switch ($this->currentStep) {
            case 1:
                // Perform actions for step 1
                $this->validateStep1();
                $this->isSuccess['1'] = true;
                break;
            case 2:
                // Perform actions for step 2
                $this->validateStep2();
                break;
            case 3:
                // Perform actions for step 3
                $this->sendTestSMS();
                break;
            default:
                // Handle unexpected step index
                break;
        }
    }
    private function validateStep1()
    {
        $this->setupAccountForm->providerId = $this->selectedProvider;

        // Move to the next step
        $this->currentStep++;
    }

    public function validateStep2()
    {
        if ($this->isStored) {
            return $this->currentStep++;
        }
        $result = $this->setupAccountForm->store();
        if ($result === true) {
            $this->status = ['type' => 'write-to-db-success', 'message' => 'Data has been saved successfully.'];
            $this->isStored = true;
            $this->isSuccess['2'] = true;
            $this->currentStep++;
        } else {
            $this->status = ['type' => 'write-to-db-error', 'message' => $result];
            $this->isError['2'] = true;
        }
        // dd($result);
        // Move to the next step
    }

    public function sendTestSMS()
    {
        // Logic to send a test SMS
        // You can use the setupAccountForm data to send the SMS
        // Example: SMSService::send($this->setupAccountForm);
        $testConfig = Sms::testSmsConfiguration($this->phone, $this->message, 'Testing Sms Configuration', $this->setupAccountForm->configId);
        // Optionally, move to the final step or show a success message
        if ($testConfig['success'] === true) {
            $this->status = ['type' => 'write-to-db-success', 'message' => 'Message has been sent successfully.'];
            $this->isSuccess['3'] = true;
            $this->currentStep++;
        } else {
            $this->status = ['type' => 'write-to-db-error', 'message' => $testConfig['message'], 'reason' => $testConfig['reason']];
            $this->isError['3'] = true;
        }
    }
    public function render()
    {
        return view('livewire.admins.settings.setup-sms-config');
    }
}
