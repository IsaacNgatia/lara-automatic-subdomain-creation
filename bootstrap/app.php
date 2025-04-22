<?php

use App\Http\Middleware\AdminAuthenticate;
use App\Http\Middleware\CheckIfPaymentIsMade;
use App\Http\Middleware\ClientAuthenticate;
use App\Http\Middleware\SwitchTenantDatabase;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminAuthenticate::class,
            'client' => ClientAuthenticate::class,
            'account_status' => CheckIfPaymentIsMade::class,
            'tenant.db' => SwitchTenantDatabase::class,
            'subdomain.access' => \App\Http\Middleware\SubdomainModuleAccess::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();