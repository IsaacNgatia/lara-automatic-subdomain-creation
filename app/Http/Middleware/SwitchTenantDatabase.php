<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SwitchTenantDatabase
{
    public function handle($request, Closure $next)
    {       // Get the subdomain from the request (e.g., "talha" from "talha.yourdomain.com")
        $subdomain = explode('.', $request->getHost())[0];

        // Fetch the user or tenant associated with this subdomain
        $user = Admin::where('subdomain', $subdomain)->first();

        // If the user is found, switch the database connection
        if ($user && !empty($user->database_name)) {
            try {
                // Create a new connection with a unique name for this tenant
                $connectionName = 'tenant_' . $user->id;

                // Set up the tenant-specific connection configuration
                $config = config('database.connections.mysql');
                $config['database'] = 'ispkenya_' .$user->database_name;

                // Add the new connection configuration
                Config::set('database.connections.' . $connectionName, $config);

                // Set the default connection to the tenant connection
                Config::set('database.default', $connectionName);

                // Store the connection details in session
                Session::put('tenant_db_connection', [
                    'name' => $connectionName,
                    'database' => 'ispkenya_' .$user->database_name
                ]);

                // Make sure the connection is established
                DB::reconnect($connectionName);

            } catch (\Exception $e) {
                Log::error('Database connection error: ' . $e->getMessage());
                abort(500, 'Database connection error');
            }
        } else {
            // For debugging
            // if (!$user) {
            //     dump('No user found for subdomain: ' . $subdomain);
            // } elseif (empty($user->database_name)) {
            //     dump('User found but database_name is empty for: ' . $subdomain);
            // }

            // Abort with a 404 error if the subdomain is not found
            abort(404, 'Subdomain not found or invalid database: ' . $subdomain);
        }

        return $next($request);
    }
}