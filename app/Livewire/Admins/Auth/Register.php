<?php

namespace App\Livewire\Admins\Auth;

use App\Models\Admin;
use App\Models\User;
use Livewire\Component;
use App\Mail\UserRegisteredMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\CpanelService;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Http;

class Register extends Component
{
    public $name, $email, $phoneNumber, $accountName, $password;
    private $baseDomain = 'nexgensoft.io';

    protected $rules = [
        'name' => 'required|string|max:255|unique:admins,name',
        'email' => 'required|email|unique:admins,email',
        'phoneNumber' => 'required|string',
        'accountName' => 'required|alpha_dash|unique:admins,account_name',
        'password' => 'required|min:6',
    ];


    public function submit()
    {
        $this->validate();

        // Check if email or account name already exists
        $existingEmail = Admin::where('email', $this->email)->first();
        $existingAccountName = Admin::where('account_name', $this->accountName)->first();

        if ($existingEmail) {
            session()->flash('error', 'The email has already been taken.');
            return;
        }

        if ($existingAccountName) {
            session()->flash('error', 'The name has already been taken.');
            return;
        }

        try {
            // $subdomainPrefix = Str::slug($this->name);
            $subdomainPrefix = Str::slug(explode(' ', $this->accountName)[0]);        
            // dd($subdomainPrefix);
            $fullSubdomain = $subdomainPrefix . '.ispkenya.xyz'; // Local subdomain
            $databaseName = 'user_' . $subdomainPrefix . '_db';

            // Store the plain password temporarily before hashing
            $plainPassword = $this->password;

            // Create the user with Billing Admin role (role_id = 3)
            $user = Admin::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone_number' => $this->phoneNumber,
                'account_name' => $this->accountName,
                'password' => Hash::make($this->password),
                'subdomain' => $subdomainPrefix,
                'database_name' => $databaseName,
                'role_id' => 3, // Set to Billing Admin role
            ]);

            Log::info('User created successfully.', ['user' => $user->id]);

            // Create database
            $this->createDatabaseAndTables($databaseName);

            // Send email with credentials
            Mail::to($this->email)->send(new \App\Mail\UserRegistrationMail(
                $this->name,
                $this->email,
                $plainPassword,
                $fullSubdomain
            ));

            session()->flash('success', "Registration successful! Visit {$fullSubdomain}. Check your email for credentials.");
                
                return redirect()->away('http://' . $fullSubdomain);
                } catch (\Exception $e) {
            Log::error('Registration failed: ' . $e->getMessage(), ['exception' => $e]);
            session()->flash('error', 'Registration failed: ' . $e->getMessage());
        }
    }
    
    
    
    
    // public function createDatabaseAndTables($newDatabaseName)
    // {
    //     try {
    //         $cpanelUsername = 'root'; // Your cPanel username
    //         $cpanelApiToken = 'BITY1OMOQ0XTJPD5KS2OZUHXWPQ6GE80'; // Replace with your API token
    //         $cpanelDomain = 'ispkenya.xyz'; // Your cPanel domain
    //         $cpanelPort = 2083; // Default cPanel port (2083 for HTTPS)

    //         $cpanelDbName = "ispkenya_{$newDatabaseName}";
    //         // 2. Create the new database
    //         DB::statement("CREATE DATABASE `$newDatabaseName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    //         Log::info("Database created: {$newDatabaseName}");

    //         // 3. Switch to the new database
    //         DB::statement("USE `$newDatabaseName`");

    //         // 4. Execute table creation queries
    //         $this->createTables();

    //         Log::info("Tables created successfully in {$newDatabaseName}");
    //     } catch (\Exception $e) {
    //         Log::error("Database/Table Creation Error: " . $e->getMessage());
    //         die($e->getMessage());
    //     }
    // }
    
    


public function createDatabaseAndTables($newDatabaseName)
{
    try {
        // Step 1: Create the database via cPanel UAPI
        $cpanelUsername = 'ispkenya';
        $cpanelApiToken = '71H8N8K3LWUXR4NH3Z8EFTCWHVC202UK';
        $cpanelDomain = '165-227-170-20.cprapid.com';
        $cpanelPort = 2083;

        // Sanitize database name
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $newDatabaseName)) {
            throw new \Exception("Invalid database name");
        }

        // cPanel database name format: username_databasename
        $cpanelDbName = "ispkenya_{$newDatabaseName}";
        if (strlen($cpanelDbName) > 64) {
            throw new \Exception("Database name too long: {$cpanelDbName}");
        }

        // Make UAPI request to create the database
        $response = Http::withHeaders([
            'Authorization' => "cpanel {$cpanelUsername}:{$cpanelApiToken}",
        ])->withOptions([
            'verify' => false,
        ])->get("https://{$cpanelDomain}:{$cpanelPort}/execute/Mysql/create_database", [
            'name' => $cpanelDbName,
        ]);

        // Log detailed response information
        Log::info("cPanel API Request Details: ", [
            'url' => "https://{$cpanelDomain}:{$cpanelPort}/execute/Mysql/create_database",
            'headers' => ['Authorization' => "cpanel {$cpanelUsername}:{$cpanelApiToken}"],
            'status' => $response->status(),
            'body' => $response->body(),
            'json' => $response->json(),
        ]);

        // Check if the API call was successful
        if ($response->failed() || !isset($response['status']) || $response['status'] != 1) {
            $error = $response['errors'][0] ?? 'Unknown error';
            if (stripos($error, 'already exists') !== false) {
                Log::info("Database already exists: {$cpanelDbName}, proceeding with table creation.");
            } else {
                throw new \Exception("Failed to create database via cPanel API: {$error}");
            }
        } else {
            Log::info("Database created via cPanel API: {$cpanelDbName}");
        }

        // Step 2: Add the user to the new database with privileges
        $response = Http::withHeaders([
            'Authorization' => "cpanel {$cpanelUsername}:{$cpanelApiToken}",
        ])->withOptions([
            'verify' => false,
        ])->get("https://{$cpanelDomain}:{$cpanelPort}/execute/Mysql/set_privileges_on_database", [
            'user' => 'ispkenya_root',
            'database' => $cpanelDbName,
            'privileges' => 'ALL PRIVILEGES',
        ]);

        if ($response->failed() || !isset($response['status']) || $response['status'] != 1) {
            $error = $response['errors'][0] ?? 'Unknown error';
            Log::error("cPanel API Response (Privileges): " . json_encode($response->json()));
            throw new \Exception("Failed to assign privileges via cPanel API: {$error}");
        }

        Log::info("Privileges assigned to user ispkenya_root for database: {$cpanelDbName}");

        // Step 3: Switch to the new database in Laravel
        config(['database.connections.tenant' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => $cpanelDbName, // Use the full cPanel database name
            'username' => env('DB_USERNAME', 'ispkenya_root'),
            'password' => env('DB_PASSWORD', 'Tf@48650821'),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]]);

        // Purge and reconnect to ensure the new database is used
        DB::purge('tenant');
        DB::reconnect('tenant');

        // Verify the current database
        $currentDatabase = DB::connection('tenant')->getDatabaseName();
        Log::info("Current database in use: {$currentDatabase}");

        if ($currentDatabase !== $cpanelDbName) {
            throw new \Exception("Failed to switch to the new database. Current database: {$currentDatabase}, Expected: {$cpanelDbName}");
        }

        // Step 4: Create tables in the new database
        $this->createTables();

        Log::info("Tables created successfully in {$cpanelDbName}");
    } catch (\Exception $e) {
        Log::error("Database/Table Creation Error: " . $e->getMessage());
        throw $e;
    }
}  

    private function createTables()
    {
        
        // Explicitly use the tenant connection for all queries
    $tenantConnection = DB::connection('tenant');

    // Set SQL mode and timezone
    $tenantConnection->statement("SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO'");
    $tenantConnection->statement("SET time_zone = '+00:00'");

    // Table: account_settings
    $tenantConnection->statement("
        CREATE TABLE IF NOT EXISTS `account_settings` (
            `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            `admin_id` bigint(20) UNSIGNED NOT NULL,
            `logo` varchar(255) DEFAULT NULL,
            `favicon` varchar(255) DEFAULT NULL,
            `name` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `url` varchar(255) DEFAULT NULL,
            `phone` varchar(255) DEFAULT NULL,
            `address` varchar(255) DEFAULT NULL,
            `user_url` varchar(255) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
        

    //   $tenantConnection->statement("
    //         CREATE TABLE `account_settings` (
    //             `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    //             `admin_id` bigint(20) UNSIGNED NOT NULL,
    //             `logo` varchar(255) DEFAULT NULL,
    //             `favicon` varchar(255) DEFAULT NULL,
    //             `name` varchar(255) NOT NULL,
    //             `email` varchar(255) NOT NULL,
    //             `url` varchar(255) DEFAULT NULL,
    //             `phone` varchar(255) DEFAULT NULL,
    //             `address` varchar(255) DEFAULT NULL,
    //             `user_url` varchar(255) DEFAULT NULL,
    //             `created_at` timestamp NULL DEFAULT NULL,
    //             `updated_at` timestamp NULL DEFAULT NULL,
    //             PRIMARY KEY (`id`)
    //         ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    //     ");

        // Table: admins
        $tenantConnection->statement("
            CREATE TABLE `admins` (
                `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                `username` varchar(255) NOT NULL,
                `email` varchar(255) NOT NULL,
                `password` varchar(255) NOT NULL,
                `two_factor_secret` text DEFAULT NULL,
                `two_factor_recovery_codes` text DEFAULT NULL,
                `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
                `role_id` bigint(20) UNSIGNED NOT NULL,
                `phone_number` varchar(255) NOT NULL DEFAULT '0712345678',
                `email_verified_at` timestamp NULL DEFAULT NULL,
                `profile_photo_path` varchar(2048) DEFAULT NULL,
                `remember_token` varchar(100) DEFAULT NULL,
                `status` enum('active','inactive','suspended','closed') NOT NULL DEFAULT 'inactive',
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        // Table: admin_logs
        $tenantConnection->statement("
            CREATE TABLE `admin_logs` (
                `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                `admin_id` bigint(20) UNSIGNED NOT NULL,
                `action` varchar(255) NOT NULL,
                `ip_address` varchar(45) NOT NULL,
                `entity_type` varchar(255) DEFAULT NULL,
                `entity_id` varchar(255) DEFAULT NULL,
                `status` enum('success','failed','pending') NOT NULL DEFAULT 'success',
                `description` text DEFAULT NULL,
                `user_agent` varchar(255) NOT NULL COMMENT 'This is the browser used to perform an action',
                `platform` varchar(255) NOT NULL COMMENT 'This is the OS',
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        // Table: admin_notes
        $tenantConnection->statement("
            CREATE TABLE `admin_notes` (
                `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                `admin_id` bigint(20) UNSIGNED NOT NULL,
                `note` text NOT NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        $tenantConnection->statement("
          CREATE TABLE `cache` (
            `key` varchar(255) NOT NULL,
            `value` mediumtext NOT NULL,
            `expiration` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
        $tenantConnection->statement("
         CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


        ");
        $tenantConnection->statement("
                    CREATE TABLE `callbacks` (
            `id` bigint(20) UNSIGNED NOT NULL,
            `payment_gateway_id` bigint(20) UNSIGNED NOT NULL,
            `result_code` int(11) NOT NULL,
            `email` varchar(255) DEFAULT NULL,
            `name` varchar(255) DEFAULT NULL,
            `customer_type` varchar(30) DEFAULT NULL,
            `customer_id` int(11) DEFAULT NULL,
            `merchant_request_id` varchar(255) NOT NULL,
            `checkout_request_id` varchar(255) DEFAULT NULL,
            `trans_id` varchar(50) DEFAULT NULL,
            `amount` int(11) DEFAULT NULL,
            `phone` varchar(20) DEFAULT NULL,
            `result_description` varchar(255) NOT NULL,
            `status` enum('pending','completed','failed') DEFAULT 'pending',
            `trans_timestamp` datetime DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


        ");
        $tenantConnection->statement("
          CREATE TABLE `client_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `status` enum('success','failed','pending') NOT NULL DEFAULT 'success',
  `description` text DEFAULT NULL,
  `user_agent` varchar(255) NOT NULL COMMENT 'This is the browser used to perform an action',
  `platform` varchar(255) NOT NULL COMMENT 'This is the OS',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


        ");
        $tenantConnection->statement("
    CREATE TABLE `complaints` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `topic` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `case_number` varchar(255) NOT NULL,
  `status` enum('open','closed') NOT NULL DEFAULT 'open',
  `is_replied` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
        $tenantConnection->statement("
    CREATE TABLE `complaint_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `complaint_id` bigint(20) UNSIGNED NOT NULL,
  `reply` text NOT NULL,
  `replied_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");
        $tenantConnection->statement("
    CREATE TABLE `customers` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `username` varchar(255) NOT NULL,
      `official_name` varchar(255) NOT NULL,
      `email` varchar(255) DEFAULT NULL,
      `is_parent` tinyint(1) DEFAULT 0,
      `parent_account` bigint(20) UNSIGNED DEFAULT NULL,
      `reference_number` varchar(255) NOT NULL,
      `phone_number` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `connection_type` enum('static','pppoe','rhsp') NOT NULL,
      `location` varchar(255) DEFAULT NULL,
      `mikrotik_id` bigint(20) UNSIGNED NOT NULL,
      `installation_fee` int(11) DEFAULT NULL,
      `billing_amount` int(11) NOT NULL,
      `balance` decimal(8,2) NOT NULL DEFAULT 0.00,
      `billing_cycle` varchar(255) NOT NULL DEFAULT '1 month',
      `status` enum('active','inactive','suspended') NOT NULL DEFAULT 'active',
      `grace_date` datetime DEFAULT NULL,
      `last_payment_date` date DEFAULT NULL,
      `expiry_date` datetime NOT NULL,
      `email_verified_at` timestamp NULL DEFAULT NULL,
      `profile_photo_path` varchar(2048) DEFAULT NULL,
      `remember_token` varchar(100) DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      `service_plan_id` bigint(20) UNSIGNED DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

        ");

        $tenantConnection->statement("
        CREATE TABLE `default_credentials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(40) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            ");


        $tenantConnection->statement("
    CREATE TABLE `email_templates` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `email_to_send` text NOT NULL,
      `subject` varchar(255) NOT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `epay_packages` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `title` varchar(255) NOT NULL,
      `password_status` tinyint(1) NOT NULL DEFAULT 1,
      `server` varchar(255) NOT NULL,
      `profile` varchar(255) NOT NULL,
      `price` int(11) NOT NULL,
      `voucher_length` int(11) NOT NULL DEFAULT 6,
      `mikrotik_id` bigint(20) UNSIGNED NOT NULL,
      `time_limit` int(11) NOT NULL,
      `data_limit` int(11) DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `expenses` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `name` varchar(255) NOT NULL,
      `expense_type_id` bigint(20) UNSIGNED NOT NULL,
      `description` text DEFAULT NULL,
      `amount` int(11) NOT NULL,
      `is_paid` tinyint(1) NOT NULL DEFAULT 0,
      `admin_id` bigint(20) UNSIGNED NOT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `expense_types` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `name` varchar(255) NOT NULL,
      `description` varchar(255) NOT NULL,
      `added_by` bigint(20) UNSIGNED DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `failed_connections` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `customer_id` bigint(20) UNSIGNED NOT NULL,
      `attempts` int(11) NOT NULL DEFAULT 0,
      `resolved` tinyint(1) NOT NULL DEFAULT 0,
      `reason` varchar(255) DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `failed_jobs` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `uuid` varchar(255) NOT NULL,
      `connection` text NOT NULL,
      `queue` text NOT NULL,
      `payload` longtext NOT NULL,
      `exception` longtext NOT NULL,
      `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `hotspot_cashes` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `voucher_name` varchar(255) NOT NULL,
      `password` varchar(255) DEFAULT NULL,
      `reference_number` varchar(255) NOT NULL,
      `time_limit` int(11) NOT NULL,
      `data_limit` int(11) NOT NULL,
      `server` varchar(255) NOT NULL,
      `profile` varchar(255) NOT NULL,
      `is_sold` tinyint(1) NOT NULL DEFAULT 0,
      `logged_in` tinyint(1) NOT NULL DEFAULT 0,
      `mikrotik_id` bigint(20) UNSIGNED NOT NULL,
      `price` int(11) NOT NULL,
      `comment` varchar(255) NOT NULL,
      `payment_date` datetime DEFAULT NULL,
      `expiry_date` datetime DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `hotspot_epays` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `password` varchar(255) DEFAULT NULL,
      `time_limit` int(11) NOT NULL,
      `data_limit` int(11) DEFAULT NULL,
      `epay_package_id` bigint(20) UNSIGNED NOT NULL,
      `price` int(11) NOT NULL,
      `is_sold` tinyint(1) NOT NULL DEFAULT 0,
      `logged_in` tinyint(1) NOT NULL DEFAULT 0,
      `mikrotik_id` bigint(20) UNSIGNED NOT NULL,
      `comment` varchar(255) NOT NULL,
      `payment_date` datetime DEFAULT NULL,
      `expiry_date` datetime DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `hotspot_recurrings` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `mikrotik_name` varchar(255) NOT NULL,
      `password` varchar(255) DEFAULT NULL,
      `server` varchar(255) NOT NULL,
      `profile` varchar(255) NOT NULL,
      `customer_id` bigint(20) UNSIGNED NOT NULL,
      `disabled` tinyint(1) NOT NULL DEFAULT 0,
      `comment` varchar(255) NOT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `invoices` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `customer_id` bigint(20) UNSIGNED NOT NULL,
      `reference_number` varchar(255) NOT NULL,
      `invoice_date` varchar(255) DEFAULT NULL,
      `due_date` varchar(255) DEFAULT NULL,
      `title` varchar(255) DEFAULT NULL,
      `total` decimal(16,2) NOT NULL DEFAULT 0.00,
      `generated_by` bigint(20) UNSIGNED DEFAULT NULL,
      `status` enum('unpaid','paid') NOT NULL DEFAULT 'unpaid',
      `notes` longtext DEFAULT NULL,
      `account_id` bigint(20) UNSIGNED DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `invoice_items` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `invoice_id` bigint(20) UNSIGNED NOT NULL,
      `service_plan_id` bigint(20) UNSIGNED NOT NULL,
      `quantity` int(11) NOT NULL DEFAULT 1,
      `rate` decimal(16,2) NOT NULL DEFAULT 0.00,
      `sub_total` decimal(16,2) NOT NULL DEFAULT 0.00,
      `from` varchar(255) DEFAULT NULL,
      `to` varchar(255) DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `jobs` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `queue` varchar(255) NOT NULL,
      `payload` longtext NOT NULL,
      `attempts` tinyint(3) UNSIGNED NOT NULL,
      `reserved_at` int(10) UNSIGNED DEFAULT NULL,
      `available_at` int(10) UNSIGNED NOT NULL,
      `created_at` int(10) UNSIGNED NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `job_batches` (
      `id` varchar(255) NOT NULL,
      `name` varchar(255) NOT NULL,
      `total_jobs` int(11) NOT NULL,
      `pending_jobs` int(11) NOT NULL,
      `failed_jobs` int(11) NOT NULL,
      `failed_job_ids` longtext NOT NULL,
      `options` mediumtext DEFAULT NULL,
      `cancelled_at` int(11) DEFAULT NULL,
      `created_at` int(11) NOT NULL,
      `finished_at` int(11) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `migrations` (
      `id` int(10) UNSIGNED NOT NULL,
      `migration` varchar(255) NOT NULL,
      `batch` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `mikrotiks` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `user` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `ip` varchar(45) NOT NULL DEFAULT '47.237.106.106',
      `port` int(11) NOT NULL,
      `location` varchar(255) NOT NULL,
      `recipient` varchar(255) DEFAULT NULL,
      `nat` tinyint(1) DEFAULT 0,
      `queue_types` tinyint(1) DEFAULT 0,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `mikrotik_packages` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `type` enum('static','pppoe') NOT NULL,
      `max_download` varchar(255) NOT NULL,
      `max_upload` varchar(255) NOT NULL,
      `mikrotik_id` bigint(20) UNSIGNED NOT NULL,
      `price` int(11) NOT NULL,
      `is_active` tinyint(1) NOT NULL DEFAULT 1,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `password_reset_tokens` (
      `email` varchar(255) NOT NULL,
      `token` varchar(255) NOT NULL,
      `created_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");


        $tenantConnection->statement("
    CREATE TABLE `payments` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `customer_id` bigint(20) UNSIGNED NOT NULL,
      `amount` decimal(16,2) NOT NULL,
      `payment_date` date DEFAULT NULL,
      `payment_method` varchar(255) DEFAULT NULL,
      `transaction_id` varchar(255) NOT NULL,
      `purpose` varchar(255) DEFAULT NULL,
      `status` enum('pending','success','failed','reversed') NOT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `payment_configs` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `payment_gateway_id` bigint(20) UNSIGNED NOT NULL,
      `short_code` varchar(255) DEFAULT NULL,
      `client_secret` varchar(255) DEFAULT NULL,
      `client_key` varchar(255) DEFAULT NULL,
      `client_id` varchar(255) DEFAULT NULL,
      `pass_key` varchar(255) DEFAULT NULL,
      `store_no` varchar(255) DEFAULT NULL,
      `till_no` varchar(255) DEFAULT NULL,
      `company_name` varchar(255) DEFAULT NULL,
      `url_registered` tinyint(1) DEFAULT 0,
      `is_working` tinyint(1) DEFAULT 0,
      `is_default` tinyint(1) DEFAULT 0,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `payment_gateways` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `name` varchar(255) NOT NULL,
      `pass_key` tinyint(1) NOT NULL,
      `client_secret` tinyint(1) NOT NULL,
      `client_key` tinyint(1) NOT NULL,
      `client_id` tinyint(1) NOT NULL,
      `short_code` tinyint(1) NOT NULL COMMENT 'For till payments this stores the HO',
      `store_no` tinyint(1) NOT NULL COMMENT 'For till url registration use this as the short code',
      `till_no` tinyint(1) NOT NULL,
      `company_name` tinyint(1) NOT NULL,
      `transaction_type` varchar(255) DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `permissions` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `name` varchar(255) NOT NULL,
      `category` enum('users','customers','invoicing','service_plan','network','reports','system','sms','security','logging') NOT NULL,
      `description` varchar(255) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `personal_access_tokens` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `tokenable_type` varchar(255) NOT NULL,
      `tokenable_id` bigint(20) UNSIGNED NOT NULL,
      `name` varchar(255) NOT NULL,
      `token` varchar(64) NOT NULL,
      `abilities` text DEFAULT NULL,
      `last_used_at` timestamp NULL DEFAULT NULL,
      `expires_at` timestamp NULL DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `pppoe_users` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `mikrotik_name` varchar(255) NOT NULL,
      `customer_id` bigint(20) UNSIGNED NOT NULL,
      `profile` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `service` varchar(255) NOT NULL DEFAULT 'pppoe',
      `remote_address` varchar(45) DEFAULT NULL,
      `disabled` tinyint(1) NOT NULL DEFAULT 0,
      `comment` varchar(255) NOT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `roles` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `name` varchar(255) NOT NULL,
      `description` varchar(255) DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");



        $tenantConnection->statement("
    CREATE TABLE `role_permissions` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `role_id` bigint(20) UNSIGNED NOT NULL,
      `permission_id` bigint(20) UNSIGNED NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `scheduled_sms` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `day_to_send` int(11) NOT NULL,
      `before_after` enum('before','after') DEFAULT 'before',
      `template` text NOT NULL,
      `type` varchar(30) DEFAULT 'expiry-sms',
      `created_by` bigint(20) UNSIGNED NOT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `service_plans` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `type` enum('static','pppoe','rhsp') NOT NULL,
      `max_download` varchar(255) DEFAULT NULL,
      `max_upload` varchar(255) DEFAULT NULL,
      `rate_limit` varchar(255) DEFAULT NULL,
      `profile` varchar(255) DEFAULT NULL,
      `mikrotik_id` bigint(20) UNSIGNED NOT NULL,
      `price` int(11) NOT NULL,
      `is_active` tinyint(1) NOT NULL DEFAULT 1,
      `billing_cycle` enum('days','weeks','months','years') NOT NULL DEFAULT 'months',
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `sessions` (
      `id` varchar(255) NOT NULL,
      `user_id` bigint(20) UNSIGNED DEFAULT NULL,
      `ip_address` varchar(45) DEFAULT NULL,
      `user_agent` text DEFAULT NULL,
      `payload` longtext NOT NULL,
      `last_activity` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `settings` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `key` varchar(255) NOT NULL,
      `value` varchar(255) NOT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `sms` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `is_sent` tinyint(1) NOT NULL DEFAULT 0,
      `recipient` varchar(255) NOT NULL,
      `message` text NOT NULL,
      `message_id` varchar(255) NOT NULL,
      `subject` varchar(255) NOT NULL,
      `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `sms_configs` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `sms_provider_id` varchar(255) NOT NULL,
      `api_key` varchar(255) DEFAULT NULL,
      `sender_id` varchar(255) DEFAULT NULL,
      `username` varchar(255) DEFAULT NULL,
      `password` varchar(255) DEFAULT NULL,
      `short_code` varchar(255) DEFAULT NULL,
      `api_secret` varchar(255) DEFAULT NULL,
      `is_default` tinyint(1) NOT NULL DEFAULT 0,
      `is_working` tinyint(1) DEFAULT NULL,
      `output_type` enum('plain','json') DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `sms_providers` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `name` varchar(255) NOT NULL,
      `api_key` tinyint(1) NOT NULL DEFAULT 0,
      `sender_id` tinyint(1) NOT NULL DEFAULT 1,
      `username` tinyint(1) NOT NULL DEFAULT 0,
      `password` tinyint(1) NOT NULL DEFAULT 0,
      `short_code` tinyint(1) NOT NULL DEFAULT 0,
      `api_secret` tinyint(1) NOT NULL DEFAULT 0,
      `_all` tinyint(1) NOT NULL DEFAULT 0,
      `output_type` enum('json','plain') DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `sms_templates` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `template` text NOT NULL,
      `subject` varchar(30) NOT NULL,
      `created_by` bigint(20) UNSIGNED NOT NULL,
      `is_active` tinyint(1) DEFAULT 1,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");



        $tenantConnection->statement("
    CREATE TABLE `static_users` (
      `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `mikrotik_name` varchar(255) NOT NULL,
      `customer_id` bigint(20) UNSIGNED NOT NULL,
      `queue_type` varchar(255) DEFAULT NULL,
      `max_download_speed` varchar(255) DEFAULT NULL,
      `disabled` tinyint(1) NOT NULL DEFAULT 0,
      `target_address` varchar(45) NOT NULL,
      `comment` varchar(255) NOT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `system_logs` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `level` enum('INFO','WARNING','ERROR','CRITICAL') NOT NULL DEFAULT 'INFO',
      `event_type` varchar(255) NOT NULL,
      `message` varchar(255) NOT NULL,
      `status` enum('success','failed','pending') NOT NULL DEFAULT 'success',
      `description` text NOT NULL,
      `file_path` varchar(255) DEFAULT NULL,
      `source` varchar(255) DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `tickets` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `type` varchar(255) NOT NULL,
      `title` varchar(255) DEFAULT NULL,
      `description` varchar(255) DEFAULT NULL,
      `user_id` bigint(20) UNSIGNED NOT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `ticket_responses` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `ticket_id` bigint(20) UNSIGNED NOT NULL,
      `message` varchar(255) NOT NULL,
      `message_by` bigint(20) UNSIGNED NOT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `ticket_types` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `name` varchar(255) NOT NULL,
      `descripttion` varchar(255) DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `transactions` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `trans_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
      `trans_amount` double NOT NULL,
      `short_code` varchar(50) DEFAULT NULL,
      `reference_number` varchar(255) DEFAULT NULL,
      `mikrotik_id` bigint(20) UNSIGNED DEFAULT NULL,
      `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
      `customer_type` varchar(255) DEFAULT NULL,
      `org_balance` double DEFAULT NULL,
      `msisdn` varchar(255) NOT NULL,
      `email` varchar(255) DEFAULT NULL,
      `first_name` varchar(255) DEFAULT NULL,
      `middle_name` varchar(255) DEFAULT NULL,
      `last_name` varchar(255) DEFAULT NULL,
      `trans_id` varchar(255) NOT NULL,
      `trans_type` varchar(255) NOT NULL,
      `payment_gateway` enum('cash','mpesa','kopokopo','flutterwave','azampay','zenopay') DEFAULT 'mpesa',
      `is_partial` tinyint(1) NOT NULL DEFAULT 0,
      `is_known` tinyint(1) NOT NULL DEFAULT 1,
      `valid_from` datetime DEFAULT NULL,
      `valid_until` datetime DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `users` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `name` varchar(255) NOT NULL,
      `email` varchar(255) NOT NULL,
      `email_verified_at` timestamp NULL DEFAULT NULL,
      `password` varchar(255) NOT NULL,
      `remember_token` varchar(100) DEFAULT NULL,
      `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
      `profile_photo_path` varchar(2048) DEFAULT NULL,
      `phone_number` varchar(255) DEFAULT NULL,
      `account_name` varchar(255) DEFAULT NULL,
      `subdomain` varchar(255) DEFAULT NULL,
      `database_name` varchar(255) DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `user_logs` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `customer_id` bigint(20) UNSIGNED NOT NULL,
      `ip_address` varchar(45) NOT NULL,
      `action` varchar(255) NOT NULL,
      `description` varchar(255) NOT NULL,
      `browser` varchar(255) NOT NULL,
      `platform` varchar(255) NOT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");

        $tenantConnection->statement("
    CREATE TABLE `wallets` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `amount` double NOT NULL,
      `customer_id` bigint(20) UNSIGNED NOT NULL,
      `transaction_id` bigint(20) UNSIGNED NOT NULL,
      `is_excess` tinyint(1) DEFAULT 0,
      `is_cleared` tinyint(1) DEFAULT 0,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
");
    }

    public function render()
    {
        return view('livewire.admins.auth.register');
    }
}