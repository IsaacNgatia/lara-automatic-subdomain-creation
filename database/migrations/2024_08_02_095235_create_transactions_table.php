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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('trans_time');
            $table->float('trans_amount');
            $table->string('short_code', length: 50)->nullable();
            $table->string('reference_number')->nullable();
            $table->foreignId('mikrotik_id')->constrained()->nullable();
            $table->foreignId('customer_id')->nullable();
            $table->string('customer_type')->nullable();
            $table->float('org_balance')->nullable();
            $table->string('msisdn');
            $table->string('email')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('trans_id');
            $table->string('trans_type');
            $table->enum('payment_gateway', ['cash', 'mpesa', 'kopokopo', 'flutterwave', 'azampay', 'zenopay'])->default('mpesa')->nullable();
            $table->boolean('is_partial')->default(false);
            $table->boolean('is_known')->default(true);
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_until')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
