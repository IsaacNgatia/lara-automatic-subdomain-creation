<?php

namespace App\Livewire\Admins\Settings;

use App\Livewire\Forms\Admin\Settings\SetupPaymentConfigForm;
use App\Models\Callback;
use App\Models\Payment;
use App\Models\PaymentConfig;
use App\Models\PaymentGateway;
use App\Models\Transaction;
use App\Services\MpesaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class SetupPaymentConfig extends Component
{
    public $paymentGateways;
    public $selectedGateway;
    public $gatewayConfig;
    public SetupPaymentConfigForm $paymentConfigForm;
    public $isOwnPaybill;
    public $isStored;
    public $isRegistered;
    public $currentStep = 1;
    public $status;
    public $stkMobile;
    public $stkAmount;
    public $storedId;
    public $merchantRequestId;
    public $transId;
    public $stkStatusDesc = '';
    public $isSuccess = ['1' => false, '2' => false, '3' => false];
    public $isError = ['1' => true, '2' => false, '3' => false];

    public function mount()
    {
        $this->paymentGateways = PaymentGateway::all();
        $this->isSuccess['1'] = false;
        $this->isStored = false;
        $this->isRegistered = false;
        $this->stkStatusDesc = 'Initiating Stk Push';
    }
    public function updatedSelectedGateway($gatewayId)
    {

        // Fetch the configuration based on the selected provider
        $this->gatewayConfig = PaymentGateway::find($gatewayId);
        $this->paymentConfigForm->gatewayConfig = $this->gatewayConfig;
        $this->isOwnPaybill = true;
    }
    public function updatedIsOwnPaybill(bool $status)
    {
        $this->isOwnPaybill = $status;
    }
    public function goBack()
    {
        $this->currentStep--;
    }
    public function submit()
    {
        try {
            $result = $this->paymentConfigForm->save();
            if ($result === true) {
                $this->status = ['type' => 'success', 'message' => 'Data has been saved successfully.'];
                $this->storedId = $this->paymentConfigForm->configId;
                $this->isStored = true;
                return true;
            } else {
                $this->status = ['type' => 'error', 'message' => $result];
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
            $this->status = ['type' => 'error', 'message' => $th->getMessage()];
        }
    }
    public function checkIndexAndCallFunction()
    {
        // Check the current step index
        switch ($this->currentStep) {
            case 1:
                // Perform actions for step 1
                $this->validateStep1();
                break;
            case 2:
                // Perform actions for step 2
                $this->validateStep2();
                break;
            case 3:
                // Perform actions for step 3
                $this->initiateStkPush();
                break;
            default:
                // Handle unexpected step index
                break;
        }
    }
    private function validateStep1()
    {
        $this->paymentConfigForm->gatewayId = $this->selectedGateway;
        $this->isStored = PaymentConfig::where('payment_gateway_id', $this->selectedGateway)->exists();
        // Move to the next step
        $this->currentStep++;
    }

    public function validateStep2()
    {
        $user = Auth::user(); // Get the authenticated user
        $this->stkMobile = $user ? $user->phone_number : null; // Safely access phone_number
        $this->stkAmount = '10';
        if ($this->isStored && $this->isRegistered) {
            return $this->currentStep++;
        } elseif (!$this->isStored && !$this->isRegistered) {
            $result = $this->paymentConfigForm->save();
            if ($result === true) {
                $this->status = ['type' => 'add-conf-success', 'add-conf-message' => 'Data has been saved successfully.'];
                $this->storedId = $this->paymentConfigForm->configId;
                $this->isStored = true;
                return;
            } else {
                $this->isError['2'] = true;
                $this->status = ['type' => 'add-conf-error', 'add-conf-message' => $result];
                return;
            }
        } elseif ($this->isStored && !$this->isRegistered) {
            return $this->registerUrl();
        }
    }
    public function registerUrl()
    {
        try {
            $result = Payment::registerUrl($this->storedId);
            if ($result['success'] === true) {
                $this->isSuccess['2'] = true;
                $this->status = ['type' => 'register-url-success', 'register-url-message' => 'SUCCESS!! URLs registered succefully'];
                $this->isRegistered = true;
                $this->currentStep++;
            } else {
                $this->isError['2'] = true;
                $this->status = ['type' => 'register-url-error', 'register-url-message' => $result['message']];
            }
        } catch (\Throwable $th) {
            return dd($th->getMessage());
        }
    }

    public function initiateStkPush()
    {

        $stkResponse = Payment::initiateStk([
            'amount' => $this->stkAmount,
            'phone' => $this->stkMobile,
            'payment-config-id' => $this->storedId,
            'customer-type' => 'admin',
            'transaction-desc' => 'Test STK',
            'account-number' => 'TEST',

        ]);
        if ($stkResponse['success'] === true) {
            $this->stkStatusDesc = 'STK Push initiated successfully';
            $this->status = ['type' => 'test-stk-success', 'test-stk-message' => $stkResponse['message']];
            $this->merchantRequestId = $stkResponse['merchant-request-id'];
            return $this->dispatch('startPollingForTransaction');
        } else {
            $this->isError['3'] = true;
            $this->status = ['type' => 'test-stk-error', 'test-stk-message' => $stkResponse['message']];
            return;
        }
        // Logic to send a test SMS
        // You can use the setupAccountForm data to send the SMS
        // Example: SMSService::send($this->setupAccountForm);

        // Optionally, move to the final step or show a success message
        // $this->currentStep++;
    }
    #[On('check-transaction-status')]
    public function checkTransactionStatus()
    {

        $this->status = ['type' => 'test-stk-success', 'test-stk-message' => 'Be patient... Waiting for callbacks...'];
        $callback = Callback::where('merchant_request_id', $this->merchantRequestId)->first();
        $transactionStatus = $callback->status;
        if ($transactionStatus !== 'pending') {
            $this->dispatch('stopPollingForTransaction');
            if ($transactionStatus === 'completed') {
                $this->status = ['type' => 'test-stk-success', 'test-stk-message' => 'Almost there... Waiting for 1 callback...'];
                $this->transId = $callback->trans_id;
                $this->dispatch('startPollingForPayment');
                $paymentConfig = PaymentConfig::where('id', $this->storedId)->first();
                $paymentConfig->update(['is_working' => 1]);
            } else {
                $this->isError['3'] = true;
                $this->status = ['type' => 'test-stk-error', 'test-stk-message' => $callback->result_description];
                return;
            }
        }
    }
    #[On('check-payment-status')]
    public function checkPaymentStatus()
    {
        // Fetch transaction using where() instead of find()
        $transaction = Transaction::where('trans_id', $this->transId)->first();
        $count = 1;
        if ($transaction) {
            // Stop polling for payment
            $this->dispatch('stopPollingForPayment');

            // Update success status
            $this->status = [
                'type' => 'test-stk-success',
                'test-stk-message' => 'Payment Successful. Name: ' . ($transaction->first_name ?? 'N/A') .
                    ' Amount: ' . ($transaction->trans_amount ?? '0.00')
            ];

            $this->isSuccess['3'] = true; // Ensure proper array key usage
            $this->currentStep++;
            return;
        } else {
            if ($count === 5) {
                // Update error status
                $this->isError['3'] = true;
                $this->status = [
                    'type' => 'test-stk-error',
                    'test-stk-message' => 'Payment Failed. Please try again.'
                ];
            }
            $count++;
            return;
        }
    }

    public function render()
    {
        return view('livewire.admins.settings.setup-payment-config');
    }
}
