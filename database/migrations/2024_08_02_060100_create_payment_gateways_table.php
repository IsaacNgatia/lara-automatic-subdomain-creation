<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('pass_key');
            $table->boolean('client_secret');
            $table->boolean('client_key');
            $table->boolean('client_id');
            $table->boolean('short_code')->comment('For till payments this stores the HO');
            $table->boolean('store_no')->comment('For till url registration use this as the short code');
            $table->boolean('till_no');
            $table->boolean('company_name');
            $table->string('transaction_type')->nullable();
            $table->timestamp('created_at');
        });
        // Insert default payment gateways
        DB::table('payment_gateways')->insert([
            ['name' => 'Safaricom Paybill', 'pass_key' => 1, 'client_secret' => 1, 'client_key' => 1, 'client_id' => 0, 'short_code' => 1, 'store_no' => 0, 'till_no' => 0, 'company_name' => 0, 'transaction_type' => 'CustomerPayBillOnline', 'created_at' => now(env('TIME_ZONE'))],
            ['name' => 'Safaricom Till', 'pass_key' => 1, 'client_secret' => 1, 'client_key' => 1, 'client_id' => 0, 'short_code' => 1, 'store_no' => 1, 'till_no' => 1, 'company_name' => 0, 'transaction_type' => 'CustomerBuyGoodsOnline',  'created_at' => now(env('TIME_ZONE'))],
            ['name' => 'Kopokopo Till', 'pass_key' => 0, 'client_secret' => 1, 'client_key' => 0, 'client_id' => 1, 'short_code' => 0, 'store_no' => 0, 'till_no' => 1, 'company_name' => 0,  'transaction_type' => NULL, 'created_at' => now(env('TIME_ZONE'))],
            ['name' => 'ZenoPay', 'pass_key' => 0, 'client_secret' => 1, 'client_key' => 1, 'client_id' => 1, 'short_code' => 0, 'store_no' => 0, 'till_no' => 0, 'company_name' => 0,  'transaction_type' => NULL, 'created_at' => now(env('TIME_ZONE'))],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
