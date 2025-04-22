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
        Schema::create('default_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('key', length: 40);
            $table->text('value');
            $table->timestamps();
        });
        DB::table('default_credentials')->insert(
            [
                ['key' => 'kenya_payment_gateway', 'value' => env('DEFAULT_KENYA_PAYMENT_GATEWAY', 'Safaricom Paybill')],
                ['key' => 'mpesa_paybill', 'value' => env('DEFAULT_MPESA_PAYBILL')],
                ['key' => 'mpesa_initiator', 'value' => env('DEFAULT_MPESA_INITITOR')],
                ['key' => 'mpesa_security_credential', 'value' => env('DEFAULT_MPESA_SECURITY_CREDENTIAL')],
                ['key' => 'mpesa_consumer_secret', 'value' => env('DEFAULT_MPESA_CONSUMER_SECRET')],
                ['key' => 'mpesa_consumer_key', 'value' => env('DEFAULT_MPESA_CONSUMER_KEY')],
                ['key' => 'mpesa_pass_key', 'value' => env('DEFAULT_MPESA_PASS_KEY')],
                ['key' => 'kenya_sms_gateway', 'value' => env('DEFAULT_SMS_GATEWAY', 'Talksasa')],
                ['key' => 'talksasa_sender_id', 'value' => env('DEFAULT_SMS_SENDER_ID')],
                ['key' => 'talksasa_api_key', 'value' => env('DEFAULT_SMS_API_KEY')],

            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_credentials');
    }
};
