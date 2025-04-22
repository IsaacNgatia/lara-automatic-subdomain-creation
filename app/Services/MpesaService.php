<?php

namespace App\Services;

use App\Models\Callback;
use App\Models\Customer;
use App\Models\DefaultCredential;
use App\Models\EpayPackage;
use App\Models\HotspotEpay;
use App\Models\HotspotVoucher;
use App\Models\Mikrotik;
use App\Models\PaymentConfig;
use App\Models\SmsTemplate;
use App\Models\Transaction;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    /**
     * Generates an access token for making API requests to Safaricom's M-Pesa API.
     *
     * @return string The access token for subsequent API requests.
     *
     * @throws \Illuminate\Http\Client\RequestException If the API request fails.
     */
    private function generateToken($id = 1)
    {
        $paymentConfig = $id ? PaymentConfig::where('id', $id)->first() : PaymentConfig::where('is_working', true)->first();

        $tokenUrl = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $credentials = base64_encode($paymentConfig['client_key'] . ':' . $paymentConfig['client_secret']);

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $credentials,
        ])->get($tokenUrl);

        $response->throw(); // Optional: throw an exception if the response status is not 2xx

        return $response->json('access_token');
    }
    /**
     * Registers a URL for receiving confirmation and validation callbacks from Safaricom's M-Pesa API.
     *
     * @return array The response from the M-Pesa API, containing the details of the registered URL.
     *
     * @throws \Illuminate\Http\Client\RequestException If the API request fails.
     */
    public function registerUrl($id)
    {
        try {

            $url = 'https://api.safaricom.co.ke/mpesa/c2b/v2/registerurl';
            $paymentConfig = PaymentConfig::where('id', $id)->first();

            $data = [
                'ShortCode' => $paymentConfig['short_code'],
                'ResponseType' => 'Completed', // Completed or Cancelled
                'ConfirmationURL' => url('api/callback/em/confirmation'),
                'ValidationURL' => url('api/callback/em/validation'),
            ];

            $token = $this->generateToken($id);

            $response = Http::withToken($token)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, $data);
            // $responseData = ["OriginatorCoversationID" => "c0fa-4e61-95ee-48c43115e9a010086991", "ResponseCode" => "0", "Response Description" => "Success"];
            $responseData = $response->json();

            if (isset($responseData['ResponseCode']) && $responseData['ResponseCode'] == '0') {
                // Success
                $originatorConversationID = $responseData['OriginatorCoversationID'] ?? null;
                $registerUrl = $paymentConfig->update(['url_registered' => 1]);
                return ['success' => true, 'message' => $responseData['Response Description'], 'result-code' => $responseData['ResponseCode']];
                // Handle success logic
            } elseif (isset($responseData['errorCode'])) {
                // Error
                $errorCode = $responseData['errorCode'];
                $errorMessage = $responseData['errorMessage'];
                return ['sucess' => false, 'message' => $errorMessage, 'result-code' => $errorCode];
                // Handle error logic
            } else {
                // Handle unexpected response
                dd($responseData);
            }
        } catch (\Throwable $th) {
            return $th->getmessage();
        }
    }
    /**
     * Simulates a Customer to Business (C2B) transaction on Safaricom's M-Pesa API.
     *
     * @param string $ShortCode The short code of the organization initiating the transaction.
     * @param string $CommandID The command for the transaction.
     * @param float $Amount The amount of the transaction.
     * @param string $Msisdn The MSISDN (phone number) of the customer initiating the transaction.
     * @param string $BillRefNumber The bill reference number for the transaction.
     *
     * @return array The response from the M-Pesa API, containing the details of the simulated transaction.
     *
     * @throws \Illuminate\Http\Client\RequestException If the API request fails.
     */
    // public function c2b($ShortCode, $CommandID, $Amount, $Msisdn, $BillRefNumber)
    public function c2b($data)
    {
        try {

            $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
            $token = $this->generateToken();
            $paymentConfig = PaymentConfig::where('id', $data['payment-config-id'])->first();
            $timestamp = date("YmdHis");
            $password = base64_encode($paymentConfig['short_code'] .  $paymentConfig['pass_key'] . $timestamp);
            $postData = [
                'BusinessShortCode' =>  $paymentConfig['short_code'],
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => $paymentConfig->paymentGateway->transaction_type,
                'Amount' => $data['amount'],
                'PartyA' => $data['phone'],
                'PartyB' =>  $paymentConfig['short_code'],
                'PhoneNumber' => $data['phone'],
                'CallBackURL' =>  url('api/callback/em/transaction'),
                'AccountReference' => $data['account-number'],
                'TransactionDesc' => $data['transaction-desc'] ?? 'Transaction',
                'Remark' => 'INITIATE STK PUSH',
            ];

            $response = Http::withToken($token)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, $postData);
            // $responseData =  [
            //     "MerchantRequestID" => "29015-34620561-1",
            //     "CheckoutRequestID" => "ws_CO_191220191020363925",
            //     "ResponseCode" => "0",
            //     "ResponseDescription" => "Success. Request accepted for processing",
            //     "CustomerMessage" => "Success. Request accepted for processing"
            // ];
            // {"requestId":"da89-4b1a-9b1e-a05101b0b0e563255089",
            // "errorCode":"401.003.01",
            // "errorMessage":"Error Occurred - Invalid Access Token - Invalid API call as no apiproduct match found"}

            $responseData = $response->json();
            if (isset($responseData['ResponseCode']) && $responseData['ResponseCode'] === '0') {

                // success
                $callback = Callback::create([
                    'merchant_request_id' => $responseData['MerchantRequestID'],
                    'checkout_request_id' => $responseData['CheckoutRequestID'],
                    'result_code' => $responseData['ResponseCode'],
                    'result_description' => $responseData['ResponseDescription'],
                    'phone' => $data['phone'],
                    'customer_type' => $data['customer-type'] ?? NULL,
                    'amount' => $data['amount'],
                    'payment_gateway_id' => $paymentConfig->payment_gateway_id,
                    'status' => 'pending',
                ]);

                return ['success' => true, 'message' => $responseData['ResponseDescription'], 'merchant-request-id' => $responseData['MerchantRequestID']];
            } else {
                $resultCode = strpos($responseData['errorCode'], '.') !== false ? explode('.', $responseData['errorCode'])[0] : $responseData['errorCode'];
                Callback::create([
                    'merchant_request_id' => $responseData['requestId'] ?? '-',
                    'result_code' => $resultCode,
                    'result_description' => $responseData['errorMessage'],
                    'phone' => $data['phone'],
                    'customer_type' => $data['customer-type'] ?? NULL,
                    'amount' => $data['amount'],
                    'payment_gateway_id' => $paymentConfig->payment_gateway_id,
                    'status' => 'failed',
                ]);
                return ['success' => false, 'message' => $responseData['errorMessage']];
            }
        } catch (\Throwable $th) {
            throw $th;
            return ['success' => false, 'message' => $th->getMessage()];
        }
    }
    /**
     * Performs a Business to Customer (B2C) transaction on Safaricom's M-Pesa API.
     *
     * @param string $InitiatorName The name of the initiator of the transaction.
     * @param string $SecurityCredential The security credential for the transaction.
     * @param string $CommandID The command for the transaction.
     * @param float $Amount The amount of the transaction.
     * @param string $PartyA The party initiating the transaction.
     * @param string $PartyB The party receiving the transaction.
     * @param string $Remarks Additional remarks for the transaction.
     * @param string $QueueTimeOutURL The URL to receive timeout notifications.
     * @param string $ResultURL The URL to receive transaction results.
     * @param string $Occasion Additional information about the transaction.
     *
     * @return array The response from the M-Pesa API, containing the details of the B2C transaction.
     *
     * @throws \Illuminate\Http\Client\RequestException If the API request fails.
     */
    public function b2c($InitiatorName, $SecurityCredential, $CommandID, $Amount, $PartyA, $PartyB, $Remarks, $QueueTimeOutURL, $ResultURL, $Occasion)
    {
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest/b2c/v1/paymentrequest';

        $data = [
            'InitiatorName' => $InitiatorName,
            'SecurityCredential' => $SecurityCredential,
            'CommandID' => $CommandID,
            'Amount' => $Amount,
            'PartyA' => $PartyA,
            'PartyB' => $PartyB,
            'Remarks' => $Remarks,
            'QueueTimeOutURL' => $QueueTimeOutURL,
            'ResultURL' => $ResultURL,
            'Occasion' => $Occasion,
        ];

        $token = $this->generateToken();

        $response = Http::withToken($token)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $data);

        return $response->json();
    }
    /**
     * Performs an account balance inquiry on Safaricom's M-Pesa API.
     *
     * @param string $Initiator The name of the initiator of the transaction.
     * @param string $SecurityCredential The security credential for the transaction.
     * @param string $PartyA The party initiating the transaction.
     * @param string $IdentifierType The type of identifier for PartyA.
     * @param string $Remarks Additional remarks for the transaction.
     * @param string $QueueTimeOutURL The URL to receive timeout notifications.
     * @param string $ResultURL The URL to receive transaction results.
     *
     * @return array The response from the M-Pesa API, containing the details of the account balance inquiry.
     *
     * @throws \Illuminate\Http\Client\RequestException If the API request fails.
     */
    public function accountBalance($Initiator, $SecurityCredential, $PartyA, $IdentifierType, $Remarks, $QueueTimeOutURL, $ResultURL)
    {
        $CommandID = "AccountBalance";
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest/accountbalance/v1/query';

        $data = [
            'CommandID' => $CommandID,
            'Initiator' => $Initiator,
            'SecurityCredential' => $SecurityCredential,
            'PartyA' => $PartyA,
            'IdentifierType' => $IdentifierType,
            'Remarks' => $Remarks,
            'QueueTimeOutURL' => $QueueTimeOutURL,
            'ResultURL' => $ResultURL,
        ];

        $token = $this->generateToken();

        $response = Http::withToken($token)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $data);

        return $response->json();
    }
    /**
     * Performs a transaction status inquiry on Safaricom's M-Pesa API.
     *
     * @param string $Initiator The name of the initiator of the transaction.
     * @param string $SecurityCredential The security credential for the transaction.
     * @param string $CommandID The command for the transaction.
     * @param string $TransactionID The unique identifier of the transaction to inquire about.
     * @param string $PartyA The party initiating the transaction.
     * @param string $IdentifierType The type of identifier for PartyA.
     * @param string $ResultURL The URL to receive transaction results.
     * @param string $QueueTimeOutURL The URL to receive timeout notifications.
     * @param string $Remarks Additional remarks for the transaction.
     * @param string $Occasion Additional information about the transaction.
     *
     * @return array The response from the M-Pesa API, containing the details of the transaction status inquiry.
     *
     * @throws \Illuminate\Http\Client\RequestException If the API request fails.
     */
    public function transactionStatus($id, $activity = 'c2b')
    {
        $Initiator = env('DEFAULT_MPESA_INITITOR', DefaultCredential::select('value')->where('key', 'mpesa_initiator')->first());
        $SecurityCredential = env('DEFAULT_MPESA_SECURITY_CREDENTIAL', DefaultCredential::select('value')->where('key', 'mpesa_security_credential')->first());
        $CommandID = 'TransactionStatusQuery';
        $PartyA = env('DEFAULT_MPESA_PAYBILL', DefaultCredential::select('value')->where('key', 'mpesa_paybill')->first());
        $IdentifierType = '4';
        $ResultURL = url('api/callback/em/query-transaction-status');
        $QueueTimeOutURL = url('api/callback/em/transaction-query-timeout');
        $Remarks = 'OK';
        $Occasion = 'OK';
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest/transactionstatus/v1/query';

        $data = [
            'Initiator' => $Initiator,
            'SecurityCredential' => $SecurityCredential,
            'CommandID' => $CommandID,
            'PartyA' => $PartyA,
            'IdentifierType' => $IdentifierType,
            'ResultURL' => $ResultURL,
            'QueueTimeOutURL' => $QueueTimeOutURL,
            'Remarks' => $Remarks,
            'Occasion' => $Occasion,
        ];
        if ($activity === 'c2b') {
            $data['TransactionID'] = $id;
        } else {
            $data['OriginatorConversationID'] = $id;
        }

        $token = $this->generateToken();
        $response = Http::withToken($token)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $data);

        return $response->json();
    }
    /**
     * Performs a Business to Business (B2B) transaction on Safaricom's M-Pesa API.
     *
     * @param string $Initiator The name of the initiator of the transaction.
     * @param string $SecurityCredential The security credential for the transaction.
     * @param float $Amount The amount of the transaction.
     * @param string $PartyA The party initiating the transaction.
     * @param string $PartyB The party receiving the transaction.
     * @param string $Remarks Additional remarks for the transaction.
     * @param string $QueueTimeOutURL The URL to receive timeout notifications.
     * @param string $ResultURL The URL to receive transaction results.
     * @param string $AccountReference The account reference for the transaction.
     * @param string $commandID The command for the transaction.
     * @param string $SenderIdentifierType The type of identifier for the sender.
     * @param string $RecieverIdentifierType The type of identifier for the receiver.
     *
     * @return array The response from the M-Pesa API, containing the details of the B2B transaction.
     *
     * @throws \Illuminate\Http\Client\RequestException If the API request fails.
     */
    public function b2b($Initiator, $SecurityCredential, $Amount, $PartyA, $PartyB, $Remarks, $QueueTimeOutURL, $ResultURL, $AccountReference, $commandID, $SenderIdentifierType, $RecieverIdentifierType)
    {
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest/b2b/v1/paymentrequest';

        $data = [
            'Initiator' => $Initiator,
            'SecurityCredential' => $SecurityCredential,
            'CommandID' => $commandID,
            'SenderIdentifierType' => $SenderIdentifierType,
            'RecieverIdentifierType' => $RecieverIdentifierType,
            'Amount' => $Amount,
            'PartyA' => $PartyA,
            'PartyB' => $PartyB,
            'AccountReference' => $AccountReference,
            'Remarks' => $Remarks,
            'QueueTimeOutURL' => $QueueTimeOutURL,
            'ResultURL' => $ResultURL,
        ];

        $token = $this->generateToken();

        $response = Http::withToken($token)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $data);

        return $response->json();
    }
    /**
     * Simulates a STK push request to Safaricom's M-Pesa API for initiating a mobile money transaction.
     *
     * @param string $payment_status The status of the payment.
     * @param string $BusinessShortCode The business short code initiating the transaction.
     * @param string $LipaNaMpesaPasskey The passkey for Lipa Na M-Pesa API.
     * @param string $TransactionType The type of transaction to be performed.
     * @param float $Amount The amount of the transaction.
     * @param string $PartyA The party initiating the transaction.
     * @param string $PartyB The party receiving the transaction.
     * @param string $PhoneNumber The phone number of the customer initiating the transaction.
     * @param string $AccountReference The account reference for the transaction.
     * @param string $TransactionDesc The description of the transaction.
     * @param string $Remark Additional remarks for the transaction.
     *
     * @return array The response from the M-Pesa API, containing the details of the simulated transaction.
     *
     * @throws \Illuminate\Http\Client\RequestException If the API request fails.
     */
    public function STKPushSimulation($payment_status, $BusinessShortCode, $LipaNaMpesaPasskey, $TransactionType, $Amount, $PartyA, $PartyB, $PhoneNumber, $AccountReference, $TransactionDesc, $Remark)
    {
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $timestamp = now()->format('YmdHis');
        $password = base64_encode(env('PAYBILL_SHORT_CODE') . env('PAYBILL_PASS_KEY') . $timestamp);

        $data = [
            'BusinessShortCode' => env('PAYBILL_SHORT_CODE'),
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => $TransactionType,
            'Amount' => $Amount,
            'PartyA' => $PartyA,
            'PartyB' => env('PAYBILL_SHORT_CODE'),
            'PhoneNumber' => $PhoneNumber,
            'CallBackURL' => url('callback/stk'),
            'AccountReference' => $AccountReference,
            'TransactionDesc' => $TransactionType,
            'Remark' => $Remark,
        ];

        $token = $this->generateToken();

        $response = Http::withToken($token)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $data);

        return $response->json();
    }
    /**
     * Performs a STK push query to Safaricom's M-Pesa API for checking the status of a previously initiated STK push request.
     *
     * @param string $checkoutRequestID The unique identifier of the STK push request to query.
     * @param string $businessShortCode The business short code initiating the transaction.
     * @param string $LipaNaMpesaPasskey The passkey for Lipa Na M-Pesa API.
     *
     * @return array The response from the M-Pesa API, containing the details of the STK push query.
     *
     * @throws \Illuminate\Http\Client\RequestException If the API request fails.
     */
    public function STKPushQuery($checkoutRequestID, $businessShortCode, $LipaNaMpesaPasskey)
    {
        $timestamp = now()->format('YmdHis');
        $password = base64_encode($businessShortCode . $LipaNaMpesaPasskey . $timestamp);

        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest/stkpushquery/v1/query';

        $data = [
            'BusinessShortCode' => $businessShortCode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'CheckoutRequestID' => $checkoutRequestID,
        ];

        $token = $this->generateToken();

        $response = Http::withToken($token)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $data);

        return $response->json();
    }
    public function processQueryTransactionStatus(array $payload)
    {
        try {
            // Extract Result Data
            $result = $payload['Result'] ?? [];

            // Extract primary details
            $transactionId = $result['TransactionID'] ?? null;
            $resultCode = $result['ResultCode'] ?? null;
            $resultDesc = $result['ResultDesc'] ?? null;

            // Extract Result Parameters
            $parameters = $result['ResultParameters']['ResultParameter'] ?? [];

            // Convert ResultParameters to an associative array
            $paramData = [];
            foreach ($parameters as $param) {
                if (isset($param['Key']) && isset($param['Value'])) {
                    $paramData[$param['Key']] = $param['Value'];
                }
            }
            //             {
            //     "Result": {
            //         "ConversationID": "AG_20180223_0000493344ae97d86f75",
            //         "OriginatorConversationID": "3213-416199-2",
            //         "ReferenceData": {
            //             "ReferenceItem": {
            //                 "Key": "Occasion"
            //             }
            //         },
            //         "ResultCode": 0,
            //         "ResultDesc": "The service request is processed successfully.",
            //         "ResultParameters": {
            //             "ResultParameter": [
            //                 {
            //                     "Key": "DebitPartyName",
            //                     "Value": "600310 - Safaricom333"
            //                 },
            //                 {
            //                     "Key": "DebitPartyName",
            //                     "Value": "254708374149 - John Doe"
            //                 },
            //                 {
            //                     "Key": "OriginatorConversationID",
            //                     "Value": "3211-416020-3"
            //                 },
            //                 {
            //                     "Key": "InitiatedTime",
            //                     "Value": "20180223054112"
            //                 },
            //                 {
            //                     "Key": "DebitAccountType",
            //                     "Value": "Utility Account"
            //                 },
            //                 {
            //                     "Key": "DebitPartyCharges",
            //                     "Value": "Fee For B2C Payment|KES|22.40"
            //                 },
            //                 {
            //                     "Key": "TransactionReason"
            //                 },
            //                 {
            //                     "Key": "ReasonType",
            //                     "Value": "Business Payment to Customer via API"
            //                 },
            //                 {
            //                     "Key": "TransactionStatus",
            //                     "Value": "Completed"
            //                 },
            //                 {
            //                     "Key": "FinalisedTime",
            //                     "Value": "20180223054112"
            //                 },
            //                 {
            //                     "Key": "Amount",
            //                     "Value": "300"
            //                 },
            //                 {
            //                     "Key": "ConversationID",
            //                     "Value": "AG_20180223_000041b09c22e613d6c9"
            //                 },
            //                 {
            //                     "Key": "ReceiptNo",
            //                     "Value": "MBN31H462N"
            //                 }
            //             ]
            //         },
            //         "ResultType": 0,
            //         "TransactionID": "MBN0000000"
            //     }
            // }

            // Extract relevant details
            $amount = $paramData['Amount'] ?? null;
            $receiptNo = $paramData['ReceiptNo'] ?? null;
            $transactionStatus = $paramData['TransactionStatus'] ?? null;
            $initiatedTime = $paramData['InitiatedTime'] ?? null;
            $finalisedTime = Carbon::createFromFormat('YmdHis', $paramData['FinalisedTime'])->format('Y-m-d H:i:s');

            // Store transaction details in the database
            Transaction::create([
                'trans_id' => $transactionId,
                'trans_amount' => $amount,
                'transaction_status' => $transactionStatus,
                'trans_time' => $finalisedTime,
                'result_code' => $resultCode,
                'result_description' => $resultDesc,
            ]);
            // Transaction::create([
            //     'trans_time' => $callbackData['TransTime'],
            //     'trans_amount' => (int) $callbackData['TransAmount'],
            //     'short_code' => $callbackData['BusinessShortCode'],
            //     'reference_number' => isset($callbackData['BillRefNumber']) ? $callbackData['BillRefNumber'] : null,
            //     'org_balance' => (int) $callbackData['OrgAccountBalance'],
            //     'msisdn' => $callbackData['MSISDN'],
            //     'first_name' => $callbackData['FirstName'],
            //     'middle_name' => $callbackData['MiddleName'],
            //     'last_name' => $callbackData['LastName'] ? $callbackData['LastName'] : null,
            //     'trans_id' => $callbackData['TransID'],
            //     'trans_type' => $callbackData['TransactionType'],
            //     'valid_from' => null,
            // ]);

            return ['success' => true, 'message' => 'Transaction processed successfully.'];
        } catch (\Exception $e) {
            Log::error('Error processing payment result: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Error processing transaction.'];
        }
    }
    public function processTransactionCallback(Request $request)
    {
        try {
            // Extracting callback data
            $data = $request->input('Body.stkCallback');

            $merchantRequestId = $data['MerchantRequestID'];
            $checkoutRequestId = $data['CheckoutRequestID'];
            $resultCode = $data['ResultCode'];
            $resultDesc = $data['ResultDesc'];
            if ($resultCode === 0) {
                // Extract metadata items
                $callbackMetadata = collect($data['CallbackMetadata']['Item'] ?? []);

                // Extract values dynamically
                $amount = $callbackMetadata->firstWhere('Name', 'Amount')['Value'] ?? null;
                $mpesaReceiptNumber = $callbackMetadata->firstWhere('Name', 'MpesaReceiptNumber')['Value'] ?? null;
                $transactionDate = $callbackMetadata->firstWhere('Name', 'TransactionDate')['Value'] ?? null;
                $phoneNumber = $callbackMetadata->firstWhere('Name', 'PhoneNumber')['Value'] ?? null;

                // Convert TransactionDate to proper format if needed
                $formattedTransactionDate = $transactionDate ? date('Y-m-d H:i:s', strtotime($transactionDate)) : null;

                // Upsert operation (insert or update)
                Callback::updateOrInsert(
                    ['merchant_request_id' => $merchantRequestId], // Unique condition
                    [
                        'checkout_request_id' => $checkoutRequestId,
                        'result_code' => $resultCode,
                        'result_description' => $resultDesc,
                        'amount' => $amount,
                        'status' => 'completed',
                        'trans_id' => $mpesaReceiptNumber,
                        'trans_timestamp' => $formattedTransactionDate,
                        'phone' => $phoneNumber,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            } else {
                Callback::updateorInsert(
                    ['merchant_request_id' => $merchantRequestId], // Unique condition
                    [
                        'checkout_request_id' => $checkoutRequestId,
                        'result_code' => $resultCode,
                        'result_description' => $resultDesc,
                        'status' => 'failed',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
            return true;
        } catch (\Throwable $th) {
            Log::info('Error with saving Transaction Callback:', ['message' => $th->getMessage()]);
            return false;
            //throw $th;
        }
    }
    public function proccessMpesaCallback(Request $request)
    {
        try {
            $callbackData = $request->all();
            $transaction = Transaction::create([
                'trans_time' => $callbackData['TransTime'],
                'trans_amount' => (int) $callbackData['TransAmount'],
                'short_code' => $callbackData['BusinessShortCode'],
                'reference_number' => isset($callbackData['BillRefNumber']) ? $callbackData['BillRefNumber'] : null,
                'org_balance' => (int) $callbackData['OrgAccountBalance'],
                'msisdn' => $callbackData['MSISDN'],
                'first_name' => $callbackData['FirstName'],
                'middle_name' => $callbackData['MiddleName'],
                'last_name' => $callbackData['LastName'] ? $callbackData['LastName'] : null,
                'trans_id' => $callbackData['TransID'],
                'trans_type' => $callbackData['TransactionType'],
                'valid_from' => null,
            ]);
            if (!isset($callbackData['BillRefNumber']) || empty($callbackData['BillRefNumber'])) {
                $transaction->update(['is_known' => 0]);
                return $transaction;
            }
            $callback = Callback::where('trans_id', $callbackData['TransID'])->first();
            if ($callback) {
                $customerType = $callback->customer_type;
                if ($customerType === 'epay-package') {
                    // Create a new epay voucher
                    $epayPackage = EpayPackage::find($callback->customer_id);
                    $connect = Mikrotik::getLoginCredentials($epayPackage->mikrotik_id);
                    $voucherData = [
                        'server' => $epayPackage->server,
                        'profile' => $epayPackage->profile,
                        'timelimit' => $epayPackage->time_limit,
                        'datalimit' => $epayPackage->data_limit,
                        'length' => $epayPackage->voucher_length,
                        'password-status' => $epayPackage->password_status,
                        'mikrotik-id' => $epayPackage->mikrotik_id,
                        'package-id' => $callback->customer_id,
                        'price' => $epayPackage->price,
                        'set-expiry' => false
                    ];

                    $createVoucher = HotspotEpay::generateHotspotVoucher($connect, $voucherData);

                    if ($createVoucher['success']) {
                        $customerId = $createVoucher['voucher']['id']->id;
                        $customerType = 'epay-hsp-voucher';
                        $transType = 'epay-hsp-voucher';
                    }
                    $transaction->update([
                        'is_known' => 1,
                        'is_partial' => 0,
                        'mikrotik_id' => $epayPackage->mikrotik_id,
                        'customer_type' => $customerType,
                        'customer_id' => $customerId,
                        'trans_type' => $transType,
                        'valid_from' => now('')->format('Y-m-d H:i:s'),
                    ]);
                }
            }
            $user = $this->checkReferenceNumber($callbackData['BillRefNumber']);
            if ($user === false) {
                return $transaction;
            }
            $connect = Mikrotik::getLoginCredentials($user['mikrotik_id']);

            if ($user['userType'] == 'hotspot') {
                if ($user['price'] >= $callbackData['TransAmount']) {
                    $comment = $user['name'] . " was purchased by " . $callbackData['FirstName'] . " at " . now(env('TIME_ZONE'))->format('Y-m-d H:i:s');
                    // Update the mikrotik information
                    $updateMikrotik = Mikrotik::purchaseHspVoucher($connect, ['comment' => $comment, 'voucher' => $user['name']]);
                    // Update the transaction details
                    $transaction->update(['is_known' => 1, 'is_partial' => 0, 'valid_from' => now('')->format('Y-m-d H:i:s')]);
                    // Update voucher in the db
                    $hotspotVoucher = HotspotEpay::find($user['id']);
                    if ($hotspotVoucher) {
                        $hotspotVoucher->update([
                            'expiry_date' => now()->addSeconds($user['timelimit']),
                            'comment' => $comment,
                            'payment_date' => now(),
                            'is_sold' => true,
                        ]);
                        return $hotspotVoucher;
                    }
                } else {
                    $comment = $user['name'] . ' was partially purchased by ' . $callbackData['FirstName'] ?? $callbackData['MSISDN'] . ' at ' . now(env('TIME_ZONE'))->format('Y-m-d H:i:s');
                    // Update mikrotik information
                    $updateMikrotik = Mikrotik::purchaseHspVoucher($connect, ['comment' => $comment, 'voucher' => $user['name']]);
                    // Update the transaction details
                    $transaction->update(['is_known' => 1, 'is_partial' => 1]);
                    // Update the voucher in the db
                    $hotspotVoucher = HotspotEpay::find($user['id']);
                    if ($hotspotVoucher) {
                        $hotspotVoucher->update([
                            'comment' => $comment,
                            'payment_date' => now(env('TIME_ZONE')),
                        ]);
                        return $hotspotVoucher;
                    }
                }
            }
            if ($user['userType'] == 'static' || $user['userType'] == 'pppoe' || $user['userType'] == 'rhsp') {
                // Fetch the user from the db
                $customer = Customer::where('reference_number', $callbackData['BillRefNumber'])->first();
                // Check total amount of the customer in his account
                $totalAmount = (int) $callbackData['TransAmount'] + (int) $customer->balance;
                if ($totalAmount >= $customer->billing_amount) {
                    // Update the Mikrotik and their respective tables
                    $updatedMikrotik = Mikrotik::updateUserAfterPayment($connect, [
                        'userType' => $user['userType'],
                        'amount' => $callbackData['BillRefNumber'],
                        'customer_id' => $customer->id
                    ]);
                    if ($updatedMikrotik) {
                        echo "Mikrotik Updated Succefully";
                    } else {
                        echo "Mikrotik was not reachable";
                    }
                    // calculate the expiry date to update
                    $expiryDate = Carbon::parse($customer->expiry_date)->isBefore(now(env('TIME_ZONE'))) ? now(env('TIME_ZONE')) : Carbon::parse($customer->expiry_date);
                    if (!is_null($customer->grace_expiry)) {
                        if (now() <= $customer->grace_expiry) {
                            $expiryDate = $customer->expiry_date;
                        } else {
                            $expiryDate = now()->sub($customer->grace_expiry->diff($customer->expiry_date));
                        }
                    }
                    // Get the expiry date dependent on the amount of the customer
                    $remainingAmount = (int) ($totalAmount % $customer->billing_amount);
                    for ($i = 0; $i < (int) ($totalAmount / $customer->billing_amount); $i++) {
                        $expiryDate = $expiryDate->add($customer->billing_cycle);
                        echo $expiryDate;
                    }
                    // update the customer table
                    $customer->update([
                        'balance' => $remainingAmount,
                        'expiry_date' => $expiryDate,
                        'grace_expiry' => null,
                        'last_payment_date' => now(env('TIME_ZONE')),
                        'status' => 'active'
                    ]);
                    // Check if there is surplus
                    if ($remainingAmount > 0) {
                        Wallet::create([
                            'customer_id' => $customer->id,
                            'transaction_id' => $transaction->id,
                            'amount' => $remainingAmount,
                            'is_excess' => true
                        ]);
                    }
                    return true;
                } else if ($totalAmount < $customer->billing_amount) {
                    $customer->update([
                        'balance' => $callbackData['TransAmount'],
                        'last_payment_date' => now(env('TIME_ZONE')),
                    ]);
                    Wallet::create([
                        'customer_id' => $customer->id,
                        'transaction_id' => $transaction->id,
                        'amount' => $callbackData['TransAmount'],
                        'is_excess' => false
                    ]);
                    return true;
                }
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    public function proccessMpesaCallbackForAssociatedAccounts(Request $request)
    {
        try {
            $callbackData = $request->all();
            $transaction = Transaction::create([
                'trans_time' => $callbackData['TransTime'],
                'trans_amount' => (int) $callbackData['TransAmount'],
                'short_code' => $callbackData['BusinessShortCode'],
                'reference_number' => isset($callbackData['BillRefNumber']) ? $callbackData['BillRefNumber'] : null,
                'org_balance' => (int) $callbackData['OrgAccountBalance'],
                'msisdn' => $callbackData['MSISDN'],
                'first_name' => $callbackData['FirstName'],
                'middle_name' => $callbackData['MiddleName'],
                'last_name' => $callbackData['LastName'] ? $callbackData['LastName'] : null,
                'trans_id' => $callbackData['TransID'],
                'trans_type' => $callbackData['TransactionType'],
                'valid_from' => null,
            ]);
            if (!isset($callbackData['BillRefNumber']) || empty($callbackData['BillRefNumber'])) {
                $transaction->update(['is_known' => 0]);
                return $transaction;
            }
            $user = $this->checkReferenceNumber($callbackData['BillRefNumber']);
            if ($user === false) {
                return $transaction;
            }
            $connect = Mikrotik::getLoginCredentials($user['mikrotik_id']);

            $remaining_amount = 0;
            if ($user['userType'] == 'hotspot') {
                if ($user['price'] >= $callbackData['TransAmount']) {
                    $comment = $user['name'] . " was purchased by " . $callbackData['FirstName'] . " at " . now(env('TIME_ZONE'))->format('Y-m-d H:i:s');
                    // Update the mikrotik information
                    $updateMikrotik = Mikrotik::purchaseHspVoucher($connect, ['comment' => $comment, 'voucher' => $user['name']]);
                    // Update the transaction details
                    $transaction->update(['is_known' => 1, 'is_partial' => 0, 'valid_from' => now('')->format('Y-m-d H:i:s')]);
                    // Update voucher in the db
                    $hotspotVoucher = HotspotEpay::find($user['id']);
                    if ($hotspotVoucher) {
                        $hotspotVoucher->update([
                            'expiry_date' => now()->addSeconds($user['timelimit']),
                            'comment' => $comment,
                            'payment_date' => now(),
                            'is_sold' => true,
                        ]);
                        return $hotspotVoucher;
                    }
                } else {
                    $comment = $user['name'] . ' was partially purchased by ' . $callbackData['FirstName'] ?? $callbackData['MSISDN'] . ' at ' . now(env('TIME_ZONE'))->format('Y-m-d H:i:s');
                    // Update mikrotik information
                    $updateMikrotik = Mikrotik::purchaseHspVoucher($connect, ['comment' => $comment, 'voucher' => $user['name']]);
                    // Update the transaction details
                    $transaction->update(['is_known' => 1, 'is_partial' => 1]);
                    // Update the voucher in the db
                    $hotspotVoucher = HotspotEpay::find($user['id']);
                    if ($hotspotVoucher) {
                        $hotspotVoucher->update([
                            'comment' => $comment,
                            'payment_date' => now(env('TIME_ZONE')),
                        ]);
                        return $hotspotVoucher;
                    }
                }
            }
            if ($user['userType'] == 'static' || $user['userType'] == 'pppoe' || $user['userType'] == 'rhsp') {
                // Fetch the user from the db
                $customer = Customer::where('reference_number', $callbackData['BillRefNumber'])->first();
                // Check total amount of the customer in his account
                $totalAmount = (int) $callbackData['TransAmount'] + (int) $customer->balance;
                if ($totalAmount >= $customer->billing_amount) {
                    // Update the Mikrotik and their respective tables
                    $updatedMikrotik = Mikrotik::updateUserAfterPayment($connect, [
                        'userType' => $user['userType'],
                        'amount' => $callbackData['BillRefNumber'],
                        'customer_id' => $customer->id
                    ]);
                    if ($updatedMikrotik) {
                        echo "Mikrotik Updated Succefully";
                    } else {
                        echo "Mikrotik was not reachable";
                    }
                    // calculate the expiry date to update
                    $expiryDate = Carbon::parse($customer->expiry_date)->isBefore(now(env('TIME_ZONE'))) ? now(env('TIME_ZONE')) : Carbon::parse($customer->expiry_date);
                    if (!is_null($customer->grace_expiry)) {
                        if (now() <= $customer->grace_expiry) {
                            $expiryDate = $customer->expiry_date;
                        } else {
                            $expiryDate = now()->sub($customer->grace_expiry->diff($customer->expiry_date));
                        }
                    }
                    // Get the expiry date dependent on the amount of the customer
                    $remainingAmount = (int) ($totalAmount % $customer->billing_amount);
                    for ($i = 0; $i < (int) ($totalAmount / $customer->billing_amount); $i++) {
                        $expiryDate = $expiryDate->add($customer->billing_cycle);
                        echo $expiryDate;
                    }
                    // update the customer table
                    $customer->update([
                        'balance' => $remainingAmount,
                        'expiry_date' => $expiryDate,
                        'grace_expiry' => null,
                        'last_payment_date' => now(env('TIME_ZONE')),
                        'status' => 'active'
                    ]);
                    // Check if there is surplus
                    if ($remainingAmount > 0) {
                        Wallet::create([
                            'customer_id' => $customer->id,
                            'transaction_id' => $transaction->id,
                            'amount' => $remainingAmount,
                            'is_excess' => true
                        ]);
                    }
                    return true;
                } else if ($totalAmount < $customer->billing_amount) {
                    $customer->update([
                        'balance' => $callbackData['TransAmount'],
                        'last_payment_date' => now(env('TIME_ZONE')),
                    ]);
                    Wallet::create([
                        'customer_id' => $customer->id,
                        'transaction_id' => $transaction->id,
                        'amount' => $callbackData['TransAmount'],
                        'is_excess' => false
                    ]);
                    return true;
                }
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    private function checkReferenceNumber($referenceNumber)
    {
        $customer = Customer::where('reference_number', $referenceNumber)->first();
        if ($customer) {
            $mikrotik = $customer->mikrotik;
            return ['id' => $customer->id, 'userType' => $customer->connection_type, 'mikrotik_id' => $mikrotik->id];
        } else {
            $hotspotVoucher = HotspotEpay::where('reference_number', $referenceNumber)->first();
            if ($hotspotVoucher) {
                $hotspotVoucher->usertype = 'hotspot';
                return $hotspotVoucher->toArray();
            } else {
                return false;
            }
        }
    }

    public function processMpesaCallbackForAssociatedAccounts(Request $request)
    {
        try {
            $callbackData = $request->all();
            Log::info('Received M-Pesa Callback:', $callbackData);

            $transaction = Transaction::create([
                'trans_time' => $callbackData['TransTime'],
                'trans_amount' => (int) $callbackData['TransAmount'],
                'short_code' => $callbackData['BusinessShortCode'],
                'reference_number' => isset($callbackData['BillRefNumber']) ? $callbackData['BillRefNumber'] : null,
                'org_balance' => (int) $callbackData['OrgAccountBalance'],
                'msisdn' => $callbackData['MSISDN'],
                'first_name' => $callbackData['FirstName'],
                'middle_name' => $callbackData['MiddleName'],
                'last_name' => $callbackData['LastName'] ? $callbackData['LastName'] : null,
                'trans_id' => $callbackData['TransID'],
                'trans_type' => $callbackData['TransactionType'],
                'valid_from' => null,
            ]);
            if (!$transaction) return response()->json(['error' => 'Transaction not created'], 500);

            if (empty($callbackData['BillRefNumber'])) {
                $transaction->update(['is_known' => 0]);
                return response()->json($transaction);
            }

            $user = $this->checkReferenceNumber($callbackData['BillRefNumber']);
            if ($user === false) {
                $transaction->update(['is_known' => 0]);
                return response()->json($transaction);
            }
            if (!$user) return response()->json($transaction);

            $transaction->update([
                'is_known' => 1,
                'customer_type' => $user['userType'],
                'customer_id' => $user['id'],
                'mikrotik_id' => $user['mikrotik_id']
            ]);

            $connect = Mikrotik::getLoginCredentials($user['mikrotik_id']);

            $amountPaid = (int) $callbackData['TransAmount'];
            $remainingAmount = $amountPaid;

            if ($user['userType'] == 'hotspot') {
                if ($remainingAmount >= $user['price']) {
                    $comment = "$user[name] purchased by $callbackData[FirstName] at " . now()->format('Y-m-d H:i:s');
                    Mikrotik::purchaseHspVoucher($connect, ['comment' => $comment, 'voucher' => $user['name']]);
                    $transaction->update([
                        'is_known' => 1,
                        'is_partial' => 0,
                        'valid_from' => now()
                    ]);

                    $hotspotVoucher = HotspotEpay::find($user['id']);
                    if ($hotspotVoucher) {
                        $hotspotVoucher->update([
                            'expiry_date' => now()->addSeconds($user['timelimit']),
                            'comment' => $comment,
                            'payment_date' => now(),
                            'is_sold' => true,
                        ]);
                    }
                    $remainingAmount -= $user['price'];
                }
            }

            if (in_array($user['userType'], ['static', 'pppoe', 'rhsp'])) {
                $customer = Customer::where('reference_number', $callbackData['BillRefNumber'])->first();
                if (!$customer) return response()->json(['error' => 'Customer not found'], 404);
                $associatedAccounts = Customer::where('parent_account', $customer->id)->orderBy('billing_amount', direction: 'desc')->get();
                $this->processPaymentForAccounts($customer, $associatedAccounts, $transaction, $remainingAmount, $connect);
            }
            return ['message' => 'Transaction processed successfully'];
        } catch (\Throwable $th) {
            Log::error('Mpesa Callback Error: ' . $th->getMessage());
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    private function processPaymentForAccounts($customer, $associatedAccounts, $transaction, &$remainingAmount, $connect)
    {
        $acknowledgementSms = SmsTemplate::where('subject', 'acknowledgement')->first();
        $smsService = new SmsService();
        if ($remainingAmount >= $customer->billing_amount) {
            Mikrotik::updateUserAfterPayment($connect, ['userType' => $customer->connection_type, 'amount' => $remainingAmount, 'customer_id' => $customer->id]);
            $expiryDate = $this->calculateExpiryDate($customer);
            $customer->update(['expiry_date' => $expiryDate, 'balance' => 0, 'last_payment_date' => now(), 'status' => 'active']);

            if (!empty($acknowledgementSms)) {
                $smsService->send(['id' => [$customer->id]], $acknowledgementSms->template, 'Acknowledgement');
            }


            $remainingAmount -= $customer->billing_amount;
        } else {
            $customer->update(['balance' => $remainingAmount, 'last_payment_date' => now()]);
            Wallet::create(['customer_id' => $customer->id, 'transaction_id' => $transaction->id, 'amount' => $remainingAmount, 'is_excess' => false]);
            return;
        }

        foreach ($associatedAccounts as $account) {
            if ($remainingAmount >= $account->billing_amount) {
                Mikrotik::updateUserAfterPayment($connect, ['userType' => $account->userType, 'amount' => $account->reference_number, 'customer_id' => $account->id]);
                $expiryDate = $this->calculateExpiryDate($account);
                $account->update(['expiry_date' => $expiryDate, 'balance' => 0, 'last_payment_date' => now(), 'status' => 'active']);
                if (!empty($acknowledgementSms)) {
                    $smsService->send(['id' => [$account->id]], $acknowledgementSms->template, 'Acknowledgement');
                }
                $remainingAmount -= $account->billing_amount;
            } else {
                break;
            }
        }

        if ($remainingAmount > 0) {
            Wallet::create(['customer_id' => $customer->id, 'transaction_id' => $transaction->id, 'amount' => $remainingAmount, 'is_excess' => true]);
        }
        return;
    }

    private function calculateExpiryDate($customer)
    {
        $expiryDate = Carbon::parse($customer->expiry_date)->isBefore(now()) ? now() : Carbon::parse($customer->expiry_date);
        return $expiryDate->add($customer->billing_cycle);
    }
}
