<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', [
                'users',
                'customers',
                'invoicing',
                'service_plan',
                'network',
                'reports',
                'system',
                'sms',
                'security',
                'logging'
            ]);
            $table->string('description');
            $table->timestamp('created_at');
        });

        // Insert default permissions
        DB::table('permissions')->insert([
            // User Management Permissions
            ['name' => 'create_user', 'category' => 'users', 'description' => 'Create a new user'],
            ['name' => 'edit_user', 'category' => 'users', 'description' => 'Edit an existing user'],
            ['name' => 'delete_user', 'category' => 'users', 'description' => 'Delete a user'],
            ['name' => 'view_user_list', 'category' => 'users', 'description' => 'View the list of users'],
            ['name' => 'manage_roles_permissions', 'category' => 'users', 'description' => 'Assign roles and permissions to users'],

            // Customer Management Permissions
            ['name' => 'add_customer', 'category' => 'customers', 'description' => 'Create a new customer account'],
            ['name' => 'edit_customer', 'category' => 'customers', 'description' => 'Edit customer information'],
            ['name' => 'delete_customer', 'category' => 'customers', 'description' => 'Delete a customer account'],
            ['name' => 'view_customer_details', 'category' => 'customers', 'description' => 'View customer information'],
            ['name' => 'manage_customer_account', 'category' => 'customers', 'description' => 'Activate, deactivate, or suspend customer account'],

            // Billing and Invoicing Permissions
            ['name' => 'generate_invoice', 'category' => 'invoicing', 'description' => 'Create customer invoices for services'],
            ['name' => 'view_invoice', 'category' => 'invoicing', 'description' => 'View invoices'],
            ['name' => 'edit_invoice', 'category' => 'invoicing', 'description' => 'Update invoice details'],
            ['name' => 'delete_invoice', 'category' => 'invoicing', 'description' => 'Delete invoices from the system'],
            ['name' => 'process_payment', 'category' => 'invoicing', 'description' => 'Record payments against invoices'],
            ['name' => 'issue_refund', 'category' => 'invoicing', 'description' => 'Process customer refunds'],
            ['name' => 'view_payment_history', 'category' => 'invoicing', 'description' => 'Access payment records'],
            ['name' => 'manage_discounts_promotions', 'category' => 'invoicing', 'description' => 'Apply discounts or promotions to invoices'],

            // Service and Subscription Management Permissions
            ['name' => 'add_service_plan', 'category' => 'service_plan', 'description' => 'Create new service plans'],
            ['name' => 'edit_service_plan', 'category' => 'service_plan', 'description' => 'Update service plans'],
            ['name' => 'delete_service_plan', 'category' => 'service_plan', 'description' => 'Remove service plans from the system'],
            ['name' => 'view_service_plans', 'category' => 'service_plan', 'description' => 'Access available service plans'],
            ['name' => 'upgrade_downgrade_plan', 'category' => 'service_plan', 'description' => 'Change a customer\'s service plan'],
            ['name' => 'suspend_resume_service', 'category' => 'service_plan', 'description' => 'Suspend or resume customer services'],

            // Network and Technical Operations Permissions
            ['name' => 'access_network_configuration', 'category' => 'network', 'description' => 'View or modify network settings'],
            ['name' => 'view_network_logs', 'category' => 'network', 'description' => 'Access logs related to network performance'],


            // Reports and Analytics Permissions
            ['name' => 'generate_financial_reports', 'category' => 'reports', 'description' => 'Create reports on revenue and expenses'],
            ['name' => 'generate_usage_reports', 'category' => 'reports', 'description' => 'View customer data usage reports'],
            ['name' => 'view_system_logs', 'category' => 'reports', 'description' => 'Access system activity logs'],
            ['name' => 'export_data', 'category' => 'reports', 'description' => 'Download reports or other data'],

            // System Settings and Configurations Permissions
            ['name' => 'configure_payment_gateways', 'category' => 'system', 'description' => 'Set up payment gateway integrations'],
            ['name' => 'manage_api_integrations', 'category' => 'system', 'description' => 'Configure API settings'],

            // SMS Permissions
            ['name' => 'send_sms', 'category' => 'sms', 'description' => 'Check SMS balance and send SMS using the system'],

            // Security and Compliance Permissions
            ['name' => 'view_audit_logs', 'category' => 'security', 'description' => 'Access logs of all user activities'],
            ['name' => 'manage_security_settings', 'category' => 'security', 'description' => 'Update security-related configurations'],
            ['name' => 'access_sensitive_data', 'category' => 'security', 'description' => 'View or export sensitive information'],

            // Logging Permissions
            ['name' => 'bypass_logging', 'category' => 'logging', 'description' => 'Activities will not recorded in the logs table'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
