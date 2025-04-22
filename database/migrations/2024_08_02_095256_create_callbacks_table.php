<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('callbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_gateway_id')->constrained('payment_gateways');
            $table->integer('result_code');
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('customer_type', length: 30)->nullable();
            $table->integer('customer_id')->nullable();
            $table->string('merchant_request_id');
            $table->string('checkout_request_id')->nullable();
            $table->string('trans_id', length: 50)->nullable();
            $table->integer('amount')->nullable();
            $table->string('phone', length: 20)->nullable();
            $table->string('result_description');
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending')->nullable();
            $table->boolean('query_transaction_status')->default(false)->nullable();
            $table->dateTime('trans_timestamp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('callbacks');
    }
};
