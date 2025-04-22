<?php

namespace App\Http\Controllers;

use App\Models\AccountSetting;
use App\Models\Callback;
use App\Models\DefaultCredential;
use App\Models\EpayPackage;
use App\Models\HotspotEpay;
use App\Models\Mikrotik;
use App\Models\PaymentConfig;
use App\Models\PaymentGateway;
use App\Models\Transaction;
use App\Services\MpesaService;
use App\Services\SmsService;
use App\Services\ZenoPayService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class HotspotController extends Controller
{
    //
    public function fetchHotspotPackages($mikrotikId)
    {
        // Fetch packages for the given Mikrotik ID
        $packages = EpayPackage::select('id', 'title', 'price', 'data_limit', 'time_limit')->where('mikrotik_id', $mikrotikId)->get();

        if ($packages->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No packages found for this Router'], 404);
        }

        return response()->json(['success' => true, 'data' => $packages]);
    }
    public function fetchAccountDetails($mikrotikId = null)
    {
        $customerServicePhone = AccountSetting::where('key', 'phone')->first()->value;
        $logo = AccountSetting::where('key', 'logo_url')->first()?->value;
        if ($mikrotikId) {
            $mikrotik = Mikrotik::where('id', $mikrotikId)->first();
            if (!$mikrotik) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mikrotik not found',
                    'data' => [
                        'logo' => is_string($logo) ? asset('storage/' . $logo) : asset('logo/temp_logo.png'),
                        'title' => AccountSetting::where('key', 'hotspot_title')->first()?->value,
                        'customer_service_phone' => $customerServicePhone,
                    ]
                ], 404);
            }
            $customerServicePhone = $mikrotik->recipient;
        }

        //
        return response()->json(['success' => true, 'data' => [
            'logo' => is_string($logo) ? asset('storage/' . $logo) : asset('logo/temp_logo.png'),
            'customer_service_phone' => $customerServicePhone,
            'title' => AccountSetting::where('key', 'hotspot_title')->first()->value,
        ]], 200);
    }
    public function createHotspotVoucher($transId, $phoneNumber, $packageId)
    {
        // Fetch transaction and package
        $transaction = Transaction::where('trans_id', $transId)->first();
        $package = EpayPackage::where('id', $packageId)->first();

        // Validate that both exist
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 400);
        }

        if (!$package) {
            return response()->json(['message' => 'Package not found'], 400);
        }

        // Fetch the corresponding Mikrotik router
        // $mikrotik = Mikrotik::where('id', $package->mikrotik_id)->first();

        // // Optional: Ensure Mikrotik exists
        // if (!$mikrotik) {
        //     return response()->json(['message' => 'Mikrotik router not found'], 400);
        // }
        if ($transaction->trans_amount >= $package->price) {
            $connect = Mikrotik::getLoginCredentials($package->mikrotik_id);
            $data = [
                'package-id' => $packageId,
                'server' => $package->server,
                'profile' => $package->profile,
                'timelimit' => $package->time_limit,
                'datalimit' => $package->data_limit,
                'length' => $package->voucher_length,
                'password-status' => $package->password_status,
                'mikrotik-id' => $package->mikrotik_id,
                'price' => $package->price
            ];
            $voucherCreatedResponse =  HotspotEpay::generateHotspotVoucher($connect, $data);
            $voucher = $voucherCreatedResponse['voucher'];
            if ($voucherCreatedResponse['success' !== true]) {
                return response()->json(['message' => $voucherCreatedResponse['message']], 400);
            }
            // Update transaction status
            $transaction->update([
                'is_known' => true,
                'customer_type' => 'epay-hsp-voucher',
                'customer_id' => $voucher['id'],
                'valid_from' => now(env('APP_TIMEZONE')),
                'valid_until' => $voucher['expiry']
            ]);


            // Send SMS
            $smsService = app(SmsService::class);
            $smsService->send(['phone' => $phoneNumber], 'Username: XXXXXX, Password: XXXXXX', 'Hotspot Voucher Details');
            return response()->json([
                'message' => 'Voucher created successfully',
                'data' => [
                    'username' => $voucher['username'],
                    'password' => $voucher['password'],
                    'timelimit' => $package['time_limit'],
                    'datalimit' => $package['data_limit'],
                    'expiry' => $voucher['expiry']
                ],

            ], 200);
        } else {
            return response()->json(['message' => 'Insufficient funds'], 400);
        }
    }
    public function initiateMpesaStk()
    {
        try {
            // 1. Validate the incoming request payload
            $validator = Validator::make(request()->all(), [
                'phone' => 'required|string|max:20',
                'package_id' => 'required|integer|exists:epay_packages,id',
                'type' => 'required|string|in:epay-package,business', // Example customer types
            ]);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $requestPayload = request()->all();

            // 2. Check if payment config is active
            $paymentConfig = PaymentConfig::where('payment_gateway_id', PaymentGateway::where('name', 'Safaricom Paybill')->first()->id)->where('is_working', 1)->first();
            if (!$paymentConfig) {
                throw new \RuntimeException("M-pesa payment gateway is currently unavailable.");
            }

            // 3. Validate EpayPackage exists
            $epayPackage = EpayPackage::find($requestPayload['package_id']);
            if (!$epayPackage) {
                throw new \RuntimeException("Selected package does not exist.");
            }

            // 4. Ensure price is valid
            if ($epayPackage->price <= 0) {
                throw new \RuntimeException("Invalid package amount.");
            }

            $c2bData = [
                'payment-config-id' => $paymentConfig->id,
                'phone' => $requestPayload['phone'],
                'amount' => $epayPackage->price,
                'account-number' => $requestPayload['phone'],
                'customer-type' => $requestPayload['type'] ?? 'epay-package',
                'customer-id' => $epayPackage->id,
            ];
            $mpesaService = new MpesaService();
            return $mpesaService->c2b($c2bData);
        } catch (Exception $e) {
            // Handle unexpected errors (returns HTTP 500)
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(), // Only in debug mode
            ], 500);
        }
    }
    public function checkMpesaTransaction($requestId)
    {
        $callback = Callback::where('merchant_request_id', $requestId)->first();
        if (!$callback) {
            return response()->json(['success' => false, 'message' => 'Transaction not found'], 404);
        }
        if ($callback->status === 'pending') {
            return response()->json(['success' => false, 'pending' => true, 'message' => 'Transaction still pending'], 200);
        } else if ($callback->status === 'completed') {
            $transaction = Transaction::where('trans_id', $callback->trans_id)->first();
            if (!$transaction) {
                if (PaymentConfig::where('payment_gateway_id', PaymentGateway::where('name', 'Safaricom Paybill')->first()->id)->where('is_working', true)->first()->short_code === env('DEFAULT_MPESA_PAYBILL', DefaultCredential::select('value')->where('key', 'mpesa_paybill')->first())) {
                    if ($callback->query_transaction_status == 0) {
                        $mpesaService = new MpesaService();
                        $transactionData = $mpesaService->transactionStatus($callback->trans_id, 'c2b');
                        return $transactionData;
                    } else {
                        return response()->json(['success' => false, 'message' => 'Transaction not found'], 404);
                    }
                }
                return ['success' => false, 'pending' => true, 'message' => 'Waiting for Payment'];
            }

            if ($transaction->customer_type === 'epay-hsp-voucher') {
                if ($transaction->customer_id == null) {
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

                    $transType = 'subscription';
                    if ($createVoucher['success']) {
                        $customerId = $createVoucher['voucher']['id']->id;
                        $customerType = 'epay-hsp-voucher';
                    }
                    Transaction::create([
                        'trans_id' => $callback->trans_id,
                        'trans_amount' => $callback->amount,
                        'trans_time' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('Y-m-d H:i:s'),
                        'msisdn' => $callback->phone,
                        'first_name' => 'epay',
                        'middle_name' => 'hsp',
                        'last_name' => $customerId,
                        'payment_gateway' => 'mpesa',
                        'is_known' => 1,
                        'is_partial' => 0,
                        'mikrotik_id' => $epayPackage->mikrotik_id,
                        'customer_type' => $customerType ?? 'epay-hsp-voucher',
                        'customer_id' => $customerId ?? null,
                        'trans_type' => $transType,
                        'valid_from' => now(env('APP_TIMEZONE', 'Africa/Nairobi'))->format('Y-m-d H:i:s'),
                    ]);
                    $callback->update([
                        'query_transaction_status' => true,
                    ]);
                    return ['success' => false, 'pending' => true, 'message' => 'Generating voucher'];
                }
                $hotspotEpay = HotspotEpay::where('id', $transaction->customer_id)->first();
                if (!$hotspotEpay) {
                    return ['success' => false, 'message' => 'Payment is pending'];
                }

                $expiryDate = $this->addSecondsToDatetime($hotspotEpay->time_limit);
                $transaction->update([
                    'valid_from' => now(env('APP_TIMEZONE')),
                    'valid_until' => $expiryDate
                ]);

                $hotspotEpay->update([
                    'is_sold' => 1,
                    'logged_in' => 1,
                    'expiry_date' => $expiryDate
                ]);
                return response()->json([
                    'success' => true,
                    'data' => [
                        'username' => $hotspotEpay->name,
                        'password' => $hotspotEpay->password,
                        'timelimit' => $hotspotEpay->time_limit,
                        'datalimit' => $hotspotEpay->data_limit,
                        'expiry' => $expiryDate,
                    ]
                ], 200);
            }
            return response()->json(['success' => true, 'message' => 'Transaction completed'], 200);
        }
    }

    public function initiateZenoStk()
    {
        try {
            // 1. Validate the incoming request payload
            $validator = Validator::make(request()->all(), [
                'email' => 'required|email',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'package_id' => 'required|integer|exists:epay_packages,id',
                'type' => 'required|string|in:epay-package,business', // Example customer types
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $requestPayload = request()->all();

            // 2. Check if payment config is active
            $paymentConfig = PaymentConfig::where('payment_gateway_id', PaymentGateway::where('name', 'ZenoPay')->first()->id)->where('is_working', 1)->first();
            if (!$paymentConfig) {
                throw new \RuntimeException("ZenoPay payment gateway is currently unavailable.");
            }

            // 3. Validate EpayPackage exists
            $epayPackage = EpayPackage::find($requestPayload['package_id']);
            if (!$epayPackage) {
                throw new \RuntimeException("Selected package does not exist.");
            }

            // 4. Ensure price is valid
            if ($epayPackage->price <= 0) {
                throw new \RuntimeException("Invalid package amount.");
            }

            // 5. Prepare and validate ZenoPay order payload
            $orderPayload = [
                'buyer-email' => $requestPayload['email'],
                'buyer-name' => $requestPayload['name'],
                'buyer-phone' => $requestPayload['phone'],
                'amount' => $epayPackage->price,
                'payment-config-id' => $paymentConfig->id,
                'customer-type' => $requestPayload['type'] ?? 'epay-package',
                'customer-id' => $epayPackage->id,
            ];

            // 6. Initiate STK push via ZenoPay service
            $zenoService = new ZenoPayService();
            return $zenoService->createOrder($orderPayload);
        } catch (ValidationException $e) {
            // Handle validation errors (returns HTTP 422)
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\RuntimeException $e) {
            // Handle business logic errors (returns HTTP 400)
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        } catch (Exception $e) {
            // Handle unexpected errors (returns HTTP 500)
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage(), // Only in debug mode
            ], 500);
        }
    }
    public function checkZenoOrderStatus($requestId)
    {
        $data = ['order-id' => $requestId, 'payment-config-id' => PaymentConfig::where('payment_gateway_id', PaymentGateway::where('name', 'ZenoPay')->first()->id)->where('is_working', 1)->first()->id];
        $zenoService = new ZenoPayService();
        return $zenoService->checkOrderStatus($data);
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
