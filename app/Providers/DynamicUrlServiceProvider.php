<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

class DynamicUrlServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Get the current request
        $request = request();

        // Get the current host
        $host = $request->getHost();

        // Get the current scheme (http or https)
        $scheme = $request->getScheme();

        // Build the base URL
        $baseUrl = $scheme . '://' . $host;

        // Set the APP_URL and ASSET_URL
        Config::set('app.url', $baseUrl);
        Config::set('app.asset_url', $baseUrl);
        // Set the base URL for the application
        URL::forceRootUrl($baseUrl);
    }
}