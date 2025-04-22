<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantModel extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Get the tenant database connection from session
        $tenantConnection = Session::get('tenant_db_connection');

        if ($tenantConnection) {
            // Set the connection for this model
            $this->connection = $tenantConnection['name'];
            
            // Ensure the connection is properly configured
            if (!Config::has('database.connections.' . $tenantConnection['name'])) {
                $config = config('database.connections.mysql');
                $config['database'] = $tenantConnection['database'];
                Config::set('database.connections.' . $tenantConnection['name'], $config);
                DB::reconnect($tenantConnection['name']);
            }
        }
    }
} 