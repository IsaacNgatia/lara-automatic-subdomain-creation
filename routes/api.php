<?php

use App\Http\Controllers\CallbackController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HotspotController;
use App\Http\Controllers\OvpnController;
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
            Route::get('/get-account-details', [HotspotController::class, 'fetchAccountDetails']);
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
            Route::post('/check-transaction-status', [HotspotController::class, 'initiateMpesaStk'])->name('mpesa.initiate.stk');
        });
    });



Route::prefix('callback')
    ->middleware('account_status')
    ->group(function () {
        // Routes from M-Pesa
        Route::prefix('em')->group(function () {
            Route::post('/confirmation', [CallbackController::class, 'mpesaCallback']);
            Route::post('/validation', [CallbackController::class, 'mpesaCallback']);
            Route::post('/transaction', [CallbackController::class, 'handleMpesaTransactionCallback']);
            Route::post('/query-transaction-status', [CallbackController::class, 'handleMpesaQueryTransactionStatusCallback']);
            Route::post('/transaction-query-timeout', [CallbackController::class, 'handleMpesaTransactionCallback']);
        });

        // Routes from ZenoPay
        Route::prefix('zno')->group(function () {
            Route::post('/process-order', [CallbackController::class, 'zenoCallback']);
        });
    });
