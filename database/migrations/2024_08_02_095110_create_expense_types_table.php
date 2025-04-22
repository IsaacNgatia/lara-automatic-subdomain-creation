<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expense_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->foreignId('added_by')
                ->nullable()
                ->constrained('admins')
                ->onDelete('cascade');

            $table->timestamps();
        });
        DB::table('expense_types')->insert([
            ['name' => 'Bandwidth Costs', 'description' => 'Fees paid to upstream providers for internet bandwidth'],
            ['name' => 'Equipment Purchases', 'description' => 'Expenses for purchasing routers, switches, servers, and other networking equipment'],
            ['name' => 'Maintenance and Repairs', 'description' => 'Costs for maintaining and repairing network infrastructure'],
            ['name' => 'Software Licenses and Subscriptions', 'description' => 'Costs for software required for network monitoring, billing, or customer management'],
            ['name' => 'Data Center Fees', 'description' => 'Fees for server hosting or data center colocation'],
            ['name' => 'Power and Cooling', 'description' => 'Utilities expenses for data centers and network equipment'],
            ['name' => 'Salaries and Wages', 'description' => 'Regular employee salaries, including technicians, customer support, and administrative staff'],
            ['name' => 'Employee Training', 'description' => 'Expenses for employee certifications or specialized training'],
            ['name' => 'Freelance/Contracted Labor', 'description' => 'Costs for outsourced or contracted technical staff'],
            ['name' => 'Office Rent', 'description' => 'Costs for office spaces'],
            ['name' => 'Utilities', 'description' => 'Electricity, water, and other utilities for office spaces'],
            ['name' => 'Office Supplies', 'description' => 'General supplies, such as stationery and equipment'],
            ['name' => 'Marketing and Advertising', 'description' => 'Costs for promoting ISP services through different channels'],
            ['name' => 'Travel and Transport', 'description' => 'Costs for employee travel, especially for on-site technical support'],
            ['name' => 'Insurance', 'description' => 'Insurance policies for equipment, offices, and liability'],
            ['name' => 'Support Software', 'description' => 'Fees for CRM, helpdesk software, and other customer support tools'],
            ['name' => 'Customer Installations', 'description' => 'Costs associated with installing equipment at customer locations'],
            ['name' => 'License Fees', 'description' => 'Regulatory fees required to operate as an ISP'],
            ['name' => 'Legal and Consulting Fees', 'description' => 'Costs for legal or consulting services, often for compliance or auditing'],
            ['name' => 'Bank and Transaction Fees', 'description' => 'Charges for transactions, payment processing, and merchant fees'],
            ['name' => 'Depreciation', 'description' => 'Accounting for the gradual devaluation of physical assets like equipment'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_types');
    }
};
