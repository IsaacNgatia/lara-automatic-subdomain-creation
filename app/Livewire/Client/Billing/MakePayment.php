<?php

namespace App\Livewire\Client\Billing;

use App\Livewire\Forms\Client\Billing\MakePayment as BillingMakePayment;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Transaction;
use App\Services\MpesaService;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

class MakePayment extends Component
{
    public BillingMakePayment $billingMakePayment;
    public $phone_number;
    public $amount;
    public $reference_number;
    public $installation_fee;
    public $customer;

    public function mount()
    {
        $this->customer = Customer::where('id', auth()->guard('client')->user()->id)->first();
        $this->phone_number = $this->customer->phone_number;
        $this->amount = 1000;
        $this->reference_number = $this->customer->reference_number;
        $this->installation_fee = $this->customer->installation_fee;
    }

    private function showModal()
    {
        $this->dispatch('open-modal');
    }
    private function closeModal()
    {
        $this->dispatch('close-modal');
    }

    public function render()
    {
        $transactions = Transaction::query()
            ->orderByDesc('id')
            ->when(
                ! empty($this->search),
                fn(Builder $q) => $q->where('reference_number', 'like', "%{$this->search}%")
            )
            ->paginate(10);

        return view('livewire.client.billing.make-payment', [
            'transactions' => $transactions
        ]);
    }

    public function makePayment(MpesaService $mpesaService)
    {

        $this->showModal();

        $this->phone_number = preg_replace('/^0/', '254', $this->phone_number);
        // $this->reference_number = preg_replace('/^0/', '254', $this->phone_number);

        $timestamp = date('Ymdhis');
        $password = base64_encode(4149535 . 'b8495b7bf72dcc4af9a41e18b0401f0891379ee5561fc484ce2e458a8da2b80f' . $timestamp);
        try {
            $data = [
                'BusinessShortCode' => '4149535',
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => "CustomerPayBillOnline",
                'Amount' => $this->amount,
                'PartyA' => $this->phone_number,
                'PartyB' => 4149535,
                'PhoneNumber' => $this->phone_number,
                'CallBackURL' =>  env('APP_URL') . "/paymentCallBack",
                'AccountReference' => $this->reference_number,
                'TransactionDesc' => 'ISP KENYA PAYMENT',
                'Remark' => $this->reference_number,
            ];
            $mpesaService->c2b(
                $data
            );
            // sleep(3);

            // $this->dispatch('close-modal');
            // Payment::initiateStk(['amount' => $this->amount, 'phone_number' => $this->phone_number]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    // public function makePayment(MpesaService $mpesaService)
    // {

    //     // $payment_status, $BusinessShortCode, $LipaNaMpesaPasskey, $TransactionType, $Amount, $PartyA, $PartyB, $PhoneNumber, $AccountReference, $TransactionDesc, $Remark


    // //  'BusinessShortCode' => env('PAYBILL_SHORT_CODE') ?? 174379,
    // //         'Password' => "MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMTYwMjE2MTY1NjI3",
    // //         'Timestamp' => C,
    // //         'TransactionType' => "CustomerPayBillOnline",
    // //         'Amount' => $this->amount,
    // //         'PartyA' => "254706506361",
    // //         'PartyB' => env('PAYBILL_SHORT_CODE') ?? 174379,
    // //         'PhoneNumber' => "254706506361",
    // //         'CallBackURL' => url('callback/stk'),
    // //         'AccountReference' => "Bill Payment",
    // //         'TransactionDesc' => "Bill Payment",
    // //         'Remark' => "Bill Payment",


    //     $mpesaService->STKPushSimulation('',env('PAYBILL_SHORT_CODE'),'MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMTYwMjE2MTY1NjI3'
    //     , 'CustomerPayBillOnline', $this->amount, '254706506361' , 174379,  '254706506361', 'Bill Payment',  'Bill Payment', '' );
    //     // $data = [
    //     //     'payment_status' => '',
    //     //     'BusinessShortCode' => '',
    //     //     'LipaNaMpesaPasskey' => '',
    //     //     'TransactionType' => '',
    //     //     'Amount' => '',
    //     //     'PartyA' => '',
    //     //     'PartyB' => '',
    //     //     'PhoneNumber' => '',
    //     //     'AccountReference' => '',
    //     //     'TransactionDesc' => '',
    //     //     'Remark' => '',
    //     // ];
    //     // $mpesaService->STKPushSimulation(
    //     //     'payment_status' => '',
    //     //     'BusinessShortCode' => '',
    //     //     'LipaNaMpesaPasskey' => '',
    //     //     'TransactionType' => '',
    //     //     'Amount' => '',
    //     //     'PartyA' => '',
    //     //     'PartyB' => '',
    //     //     'PhoneNumber' => '',
    //     //     'AccountReference' => '',
    //     //     'TransactionDesc' => '',
    //     //     'Remark' => '',
    //     // );
    //     // public function STKPushSimulation()


    //     // dd("Payment is being processed.");

    //     // $this->billingMakePayment-> = $this->selectedTicket->id;
    //     // $this->billingMakePayment->complaintId = $this->selectedTicket->id;
    //     // $this->billingMakePayment->complaintId = $this->selectedTicket->id;
    //     // $this->newTicketReply->validate();
    //     // $saveResult = $this->newTicketReply->save();

    //     // // Check the save result and display appropriate flash message
    //     // if ($saveResult) {

    //     //     session()->flash('success', 'Reply sent successfully.');
    //     //     try {
    //     //         $response = Sms::sendSms(
    //     //             ['phone' => '0706506361'],
    //     //             'This is a test message.',
    //     //             'Test Subject'
    //     //         );
    //     //     } catch (\Throwable $th) {
    //     //         dd($th);
    //     //     }
    //         // $this->newTicketReply->reset();`
    //         // $this->dispatch('expense-type-created');
    //     // } else {
    //     //     session()->flash('error', 'Failed to create expense type.');
    //     // }
    // }

    public function allocatePayment()
    {

        //Check if customer has paid installation fee
        //YES



        //NO
        //Make payment to installation
        //Get remainder
        //Pay for the parent account
        //











        //Check if installation fee is paid
        // if ($this->customer->payments()->count() == 0) {
        //     // First payment
        //     if ($this->amount >= $this->installation_fee) {
        //         Payment::create([
        //             'customer_id' => $this->customer->id,
        //             'amount' => $this->customer->installation_fee,
        //             'payment_date' => now(env('APP_TIMEZONE', 'Africa/Nairobi')),
        //             'payment_method' => "MPESA",
        //             'transaction_id' => "MPESATXNID",
        //             'purpose' => 'installation fee',
        //             'status' => 'success',
        //         ]);
        //         $this->amount -= $this->installation_fee;
        //         // Allocate installation fee
        //         $this->customer->installations()->create([
        //             'amount' => $this->installation_fee,
        //             'description' => 'Installation Fee'
        //         ]);
        //     }

        // if ($amount >= $service_fee) {
        //     $amount -= $service_fee;
        //     // Allocate service fee
        //     $customer->services()->create([
        //         'amount' => $service_fee,
        //         'description' => 'Service Fee',
        //         // TODO::Add billing cycle here
        //         'expiry_date' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->addDays(30)
        //     ]);
        // }

        // if ($amount > 0) {
        //     // Allocate remaining amount to wallet
        //     $customer->wallet()->create([
        //         'amount' => $amount,
        //         'description' => 'Remaining Balance'
        //     ]);
        // }
        // } else {
        // Subsequent payments
        // $services = $customer->services()->where('expiry_date', '<', now(env('APP_TIMEZONE', 'Africa/Nairobi')))->get();

        // foreach ($services as $service) {
        // if ($amount >= $service_fee) {
        //     $amount -= $service_fee;
        //     // Extend service expiry date
        //     $service->update([
        //     'expiry_date' => $service->expiry_date->addDays(30)
        //     ]);
        // }
        // }

        // if ($amount > 0) {
        // // Allocate remaining amount to wallet
        // $customer->wallet()->create([
        //     'amount' => $amount,
        //     'description' => 'Remaining Balance'
        // ]);
        // }
        // }
    }
}
