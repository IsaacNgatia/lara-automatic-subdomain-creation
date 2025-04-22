<?php

use App\Http\Controllers\CallbackController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HotspotController;
use App\Http\Controllers\OvpnController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/cron/disconnect-customers', [CustomerController::class, 'disconnectCustomers'])->middleware('account_status');
Route::post('/setup-router', [OvpnController::class, 'setupRouter']);
Route::get('/fetch-client-file/{folderName}/{password}/{fileName}', [OvpnController::class, 'fetchClientFile']);

Route::get('/create-hotspot-voucher/{transId}/{phoneNumber}/{packageId}', [HotspotController::class, 'createHotspotVoucher']);

// Hotspot Payment Routes
Route::prefix('hsp')
    ->group(function () {
        Route::prefix('epay')->group(function () {
            Route::get('/get-account-details/{mikrotikId}', [HotspotController::class, 'fetchAccountDetails']);
            Route::get('/fetch-hotspot-packages/{mikrotikId}', [HotspotController::class, 'fetchHotspotPackages']);
        });

        // ZenoPay Routes
        Route::prefix('zno')->group(function () {
            Route::post('/create-order', [HotspotController::class, 'initiateZenoStk'])->name('zeno.create.order');
            Route::get('/check-order/{requestId}', [HotspotController::class, 'checkZenoOrderStatus'])->name('zeno.check.order');
        });

        // M-Pesa Routes
        Route::prefix('em')->group(function () {
            Route::post('/initiate-stk', [HotspotController::class, 'initiateMpesaStk'])->name('mpesa.initiate.stk');
            Route::get('/check-transaction-status/{requestId}', [HotspotController::class, 'checkMpesaTransaction'])->name('mpesa.check.transaction.status');
        });
    });


Route::prefix('callback')
    ->middleware('account_status')
    ->group(function () {
        // Routes from M-Pesa
        Route::prefix('em')->group(function () {
            Route::post('/test', [PaymentController::class, 'testMpesa'])->name('mpesa.payment.test.callback');
            Route::post('/confirmation', [CallbackController::class, 'mpesaCallback'])->name('mpesa.payment.callback');
            Route::post('/validation', [CallbackController::class, 'mpesaCallback'])->name('mpesa.payment.validation');
            Route::post('/transaction', [CallbackController::class, 'handleMpesaTransactionCallback'])->name('mpesa.transaction.callback');
            Route::post('/transaction-diff-receiver', [CallbackController::class, 'handleMpesaTransactionCallback'])->name('mpesa.transaction.callback');
            Route::post('/query-transaction-status', [CallbackController::class, 'handleMpesaQueryTransactionStatusCallback']);
            Route::post('/transaction-query-timeout', [CallbackController::class, 'handleMpesaTransactionCallback']);
        });

        // Routes from ZenoPay
        Route::prefix('zno')->group(function () {
            Route::post('/process-order', [CallbackController::class, 'zenoCallback'])->name('zeno.initiate.stk');
        });
    });
