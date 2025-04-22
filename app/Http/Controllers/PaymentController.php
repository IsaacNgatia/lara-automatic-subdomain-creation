<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PaymentConfig;
use App\Services\MpesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    //
    public static function stkApi(Request $request)
    {
        $mpesaService = new MpesaService();
        $data = $request->all();
        $configId = PaymentConfig::where('is_working', true)->first();
        if (!$configId) {
            return response()->json(['error' => 'No working MPESA provider configured.'], 400);
        }
        $data = [
            'amount' => $data['amount'],
            'phone' => $data['phone'],
            'payment-config-id' => $configId,
            'transaction-desc' => 'Hotspot Voucher Purchase',
            'account-number' => $data['phone'],
            'customer-type' => 'hotspot-voucher'
        ];
        return $mpesaService->c2b(
            $data
        );
    }
    public function testMpesa(Request $request)
    {
        try {
            $data = $request->all();

            $customer = Customer::where('reference_number', $data['BillRefNumber'])->first();
            return Customer::activateCustomerOnAmountPaid($data['TransAmount'], $customer->id);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }
}
