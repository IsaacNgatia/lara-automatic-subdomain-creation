<?php

namespace App\Http\Controllers;

use App\Models\Callback;
use App\Models\Customer;
use App\Services\MpesaService;
use App\Services\ZenoPayService;
use Illuminate\Http\Request;

class CallbackController extends Controller
{
    public function mpesaCallback(Request $request)
    {
        $customer = Customer::where('reference_number', $request['BillRefNumber'])->first();
        if (!$customer) {
            try {
                $mpesaService = new MpesaService();
                $result = $mpesaService->proccessMpesaCallback($request);
                return response()->json(data: $result);
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        } else {
            try {
                $mpesaService = new MpesaService();
                $result = $mpesaService->processMpesaCallbackForAssociatedAccounts($request);
                return response()->json(data: $result);
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }
    }
    public function handleMpesaTransactionCallback(Request $request)
    {
        $mpesaService = new MpesaService();
        $processTransactionCallback = $mpesaService->processTransactionCallback($request);
        return response()->json(['success' => $processTransactionCallback, 'message' => 'Callback processed successfully'], 200);
    }
    public function handleMpesaQueryTransactionStatusCallback(Request $request)
    {
        $mpesaService = new MpesaService();
        $processQueryTransactionCallback = $mpesaService->processQueryTransactionStatus($request->all());
        return response()->json(['success' => $processQueryTransactionCallback, 'message' => 'Callback processed successfully'], 200);
    }
    public function zenoCallback(Request $request)
    {
        $zenoPayService = new ZenoPayService();
        return $zenoPayService->handleOrderCallback();
    }
}
