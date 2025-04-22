<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ClientAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        Auth::shouldUse('client');

        if (!Auth::guard('client')->check()) {
            return redirect(route('client.login'));
        }
        return $next($request);
    }
}
