<?php

namespace App\Services;

use App\Models\Callback;
use App\Models\EpayPackage;
use App\Models\HotspotEpay;
use App\Models\Mikrotik;
use App\Models\PaymentConfig;
use App\Models\PaymentGateway;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class ZenoPayService
{

    public function createOrder(array $data)
    {
        // Validate required fields
        $requiredFields = ['buyer-email', 'buyer-name', 'buyer-phone', 'amount', 'payment-config-id'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new \InvalidArgumentException("Missing required field: $field");
            }
        }

        $paymentConfig = PaymentConfig::where('id', $data['payment-config-id'])->first();

        // Prepare the payload
        $payload = [
            'create_order' => 1,
            'buyer_email' => $data['buyer-email'],
            'buyer_name' => $data['buyer-name'],
            'buyer_phone' => $data['buyer-phone'],
            'amount' => $data['amount'],
            'account_id' => $paymentConfig['client_id'],
            'api_key' => $paymentConfig['client_key'],
            'secret_key' => $paymentConfig['client_secret'],
            'webhook_url' => url('callback/zno/process-order'),
            'metadata' => json_encode([
                "product_id" => "12345",
                "color" => "blue",
                "size" => "L",
                "custom_notes" => "Please gift-wrap this item."
            ])
        ];

        try {
            $response = Http::asForm()->post('https://api.zeno.africa', $payload);

            // Check for HTTP errors
            if ($response->failed()) {
                throw new \RuntimeException("HTTP Error: " . $response->status() . " - " . $response->body());
            }


            $responseData = $response->json();

            // {"status":"success","message":"Request in progress. You will receive a callback shortly","order_id":"67e0192349a89"}
            if (strtolower($responseData['status']) == 'success') {
                Callback::create([
                    'payment_gateway_id' => $paymentConfig->payment_gateway_id,
                    'merchant_request_id' => $responseData['order_id'] ?? '-',
                    'result_code' => $response->status(),
                    'result_description' => $responseData['message'],
                    'phone' => $data['buyer-phone'],
                    'email' => $data['buyer-email'],
                    'customer_type' => $data['customer-type'] ?? NULL,
                    'customer_id' => $data['customer-id'] ?? NULL,
                    'amount' => $data['amount'],
                    'name' => $data['buyer-name'],
                    'status' => 'pending',
                ]);
                return ['success' => true, 'message' => 'Request in progress. Kindly check your phone', 'request_id' => $responseData['order_id']];
            } else {
                // {"status":"error","message":"Failed to process payment request"}
                Callback::create([
                    'payment_gateway_id' => $paymentConfig->payment_gateway_id,
                    'merchant_request_id' => '-',
                    'result_code' => '400',
                    'result_description' => $responseData['message'],
                    'phone' => $data['buyer-phone'],
                    'email' => $data['buyer-email'],
                    'customer_type' => $data['customer-type'] ?? NULL,
                    'customer_id' => $data['customer-id'] ?? NULL,
                    'amount' => $data['amount'],
                    'name' => $data['buyer-name'],
                    'status' => 'failed',
                ]);
                return ['success' => false, 'message' => $responseData['message']];
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("HTTP Request Failed: " . $e->getMessage());
        }
    }

    public function checkOrderStatus($data)
    {
        $requiredFields = ['order-id', 'payment-config-id'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new \InvalidArgumentException("Missing required field: $field");
            }
        }

        $paymentConfig = PaymentConfig::where('id', $data['payment-config-id'])->first();

        // Prepare the payload
        $payload = [
            'check_status' => 1,
            'order_id' => $data['order-id'],
            'api_key' => $paymentConfig['client_key'],
            'secret_key' => $paymentConfig['client_secret'],
        ];

        try {
            $response = Http::asForm()->post('https://api.zeno.africa/order-status', $payload);

            // Check for HTTP errors
            if ($response->failed()) {
                throw new \RuntimeException("HTTP Error: " . $response->status() . " - " . $response->body());
            }
            //{
            //     "status": "success",
            //     "order_id": "67e0192349a89",
            //     "message": "Order fetch successful",
            //     "amount": "1000.00",
            //     "payment_status": "COMPLETED"
            // }
            $responseData = $response->json();
            $callback = Callback::where('merchant_request_id', $data['order-id'])->first();
            if (strtolower($responseData['payment_status']) === 'completed' || $callback->status === 'completed') {

                strtolower($responseData['payment_status']) === 'completed' && $callback->update(['status' => 'completed', 'updated_at' => now()]);
                $result = [
                    'success' => true,
                    'message' => 'Transaction has been received successfully'
                ];
                $transaction = Transaction::where('trans_id', $callback->trans_id)->first();
                if ($transaction->customer_type === 'epay-hsp-voucher') {
                    $hotspotEpay = HotspotEpay::where('id', $transaction->customer_id)->first();
                    $expiryDate = $this->addSecondsToDatetime($hotspotEpay->time_limit);
                    $transaction->update([
                        'valid_from' => now(env('APP_TIMEZONE')),
                        'valid_until' => $expiryDate,
                        'updated_at' => now(env('APP_TIMEZONE')),
                    ]);

                    $hotspotEpay->update([
                        'is_sold' => 1,
                        'logged_in' => 1,
                        'expiry_date' => $expiryDate,
                        'updated_at' => now(env('APP_TIMEZONE')),
                    ]);
                    $result['data'] = [
                        'username' => $hotspotEpay->name,
                        'password' => $hotspotEpay->password,
                        'timelimit' => $hotspotEpay->time_limit,
                        'datalimit' => $hotspotEpay->data_limit,
                        'expiry' => $expiryDate,
                    ];
                }

                return $result;
            } else if (strtolower($responseData['payment_status']) == 'pending') {
                return ['success' => false, 'pending' => true, 'message' => 'Transaction is pending!'];
            }


            // Return the response body
            return $response->body();
        } catch (\Exception $e) {
            throw new \RuntimeException("HTTP Request Failed: " . $e->getMessage());
        }
    }

    public function handleOrderCallback()
    {
        // {"order_id":"6757c69cddfa6","payment_status":"COMPLETED","reference":"0882061614"}
        $data = request()->all();
        try {
            if (strtolower($data['payment_status']) !== 'completed') {
                // Handle failed payment
                Log::error("Failed payment: Order ID - {$data['order_id']}, Payment Status - {$data['payment_status']}, Reference - {$data['reference']}");
                return ['success' => false, 'message' => 'Transaction failed'];
            }
            $callback = Callback::where('merchant_request_id', $data['order_id'])->first();
            $firstName = null;
            $middleName = null;
            $lastName = null;
            $isKnown = false;
            $isPartial = false;
            $email = null;
            $phone = null;
            $customerType = null;
            $customerId = null;
            $validFrom = null;
            $validUntil = null;
            $paymentGateway = PaymentGateway::where('name', 'ZenoPay')->first()->id;
            $transType = 'subscription';
            $transTime = now();
            if ($callback) {
                $validFrom = $transTime;
                $callback->update([
                    'result_description' => $data['payment_status'],
                    'trans_id' => $data['reference'],
                    'status' => 'completed',
                    'updated_at' => $transTime,
                ]);
                $amount = (int)$callback->amount;
                $fullName = $callback->name;
                $names = explode(' ', $fullName);
                $firstName = $names[0] ?? null;
                $middleName = isset($names[2]) ? $names[1] : null;
                $lastName = $names[count($names) - 1] ?? null;
                $isKnown = true;
                $isPartial = false;
                $email = $callback->email;
                $phone = $callback->phone;
                if ($callback->customer_type === 'epay-package') {
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
                }
            } else {
                $workingZenoConfig = $this->checkWorkingZenoPayConf();
                $payload = [
                    'check_status' => 1,
                    'order_id' => $data['order_id'],
                    'api_key' => $workingZenoConfig['client_key'],
                    'secret_key' => $workingZenoConfig['client_secret'],
                ];
                $response = Http::asForm()->post('https://api.zeno.africa/order-status', $payload);
                $responseData = $response->json();
                if (!strtolower($responseData['status']) == 'completed') {
                    // Log error
                    Log::error("Failed to update callback status for order_id: {$data['order_id']}, response: " . $response->body());
                    return ['success' => false, 'message' => 'Failed to update callback status'];
                }
                $amount = (int)$responseData['amount'];
            }
            Transaction::create([
                'trans_time' => $transTime,
                'trans_amount' => $amount,
                'trans_id' => $data['reference'],
                'trans_type' => $transType,
                'payment_gateway' =>  'zenopay',
                'short_code' => PaymentConfig::where('payment_gateway_id', PaymentGateway::where('name', 'ZenoPay')->first()->id)->where('is_working', 1)->first()->client_id,
                'customer_id' => $customerId,
                'customer_type' => $customerType,
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'last_name' => $lastName,
                'is_known' => $isKnown,
                'is_partial' => $isPartial,
                'email' => $email,
                'msisdn' => $phone,
                'valid_from' => $validFrom,
                'valid_until' => $validUntil,

            ]);
            return ['success' => true, 'message' => 'Transaction saved successfully'];
        } catch (Exception $e) {
            return $e->getMessage();
            throw new RuntimeException("HTTP Request Failed: " . $e->getMessage());
        }
    }
    private function checkWorkingZenoPayConf()
    {
        $paymentGateway = PaymentGateway::where('name', 'ZenoPay')->where('is_working', 1)->first();
        if (!$paymentGateway) {
            throw new \Exception("No working ZenoPay configuration found");
        }
        return $paymentGateway;
    }
    private function addSecondsToDatetime(int $seconds, $datetime = null): string
    {
        // Get the timezone from the .env file or default to UTC
        $timezone = env('APP_TIMEZONE', 'UTC');

        // Create a DateTime object with the correct timezone
        $date = new \DateTime($datetime ?? 'now', new \DateTimeZone($timezone));

        // Add seconds to the datetime
        $date->modify("+{$seconds} seconds");

        return $date->format('Y-m-d H:i:s'); // Convert to string format
    }
}
