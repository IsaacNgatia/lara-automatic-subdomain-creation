<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubdomainModuleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Initialize hideModules as an empty array by default
        $hideModules = [];

        // Get the current subdomain
        $subdomain = $request->route('subdomain');
        
        // If we're on a subdomain, hide certain modules
        if ($subdomain) {
            $hideModules = ['users', 'settings'];
        }

        // Store in session
        session(['hideModules' => $hideModules]);

        // Share with all views
        view()->share('hideModules', $hideModules);

        return $next($request);
    }
} 