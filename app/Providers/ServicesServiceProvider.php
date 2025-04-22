<?php

namespace App\Providers;

use App\Services\SmsService;
use Illuminate\Support\ServiceProvider;
use App\Services\MpesaService;
use App\Services\OvpnService;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MpesaService::class, function ($app) {
            return new MpesaService();
        });
        $this->app->singleton(SmsService::class, function ($app) {
            return new SmsService();
        });
        $this->app->singleton(OvpnService::class, function ($app) {
            return new OvpnService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
