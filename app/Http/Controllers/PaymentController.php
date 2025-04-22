<?php

namespace App\Http\Controllers;

use App\Models\PaymentConfig;
use App\Services\MpesaService;
use Illuminate\Http\Request;

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
}
