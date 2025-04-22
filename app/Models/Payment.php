<?php

namespace App\Models;

use App\Services\MpesaService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;

class Payment extends Model
{
    protected $fillable = [
        'customer_id',
        'amount',
        'payment_date',
        'payment_method',
        'transaction_id',
        'purpose',
        'status',
    ];


    public static function initiateStk($data)
    {
        $mpesaService = new MpesaService();
        $configId = $data['payment-config-id'];
        if (!$data['payment-config-id'] || $data['payment-config-id'] == '') {
            $configId = PaymentConfig::where('is_working', true)->first();
        }
        $data = [
            'amount' => $data['amount'],
            'phone' => $data['phone'],
            'payment-config-id' => $configId,
            'transaction-desc' => $data['transaction-desc'],
            'account-number' => $data['account-number'],
            'customer-type' => $data['customer-type']
        ];
        return $mpesaService->c2b(
            $data
        );
        // $mpesaService->c2b(
        //     '4149535',
        //     $data['phone_number'],
        //     $data['amount'],
        //     $data['phone_number'],
        //     'Bill Payment',
        // );
    }
    public static function registerUrl($paymentConfigId)
    {
        try {
            $mpesaService = new MpesaService();
            return $mpesaService->registerUrl($paymentConfigId);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
