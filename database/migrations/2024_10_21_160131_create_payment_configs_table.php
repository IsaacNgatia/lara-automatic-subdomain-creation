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
        Schema::create('payment_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_gateway_id')->constrained()->cascadeOnDelete();
            $table->string('short_code')->nullable();
            $table->string('client_secret')->nullable();
            $table->string('client_key')->nullable();
            $table->string('client_id')->nullable();
            $table->string('pass_key')->nullable();
            $table->string('store_no')->nullable();
            $table->string('till_no')->nullable();
            $table->string('company_name')->nullable();
            $table->boolean('url_registered')->default(false)->nullable();
            $table->boolean('is_working')->default(false)->nullable();
            $table->boolean('is_default')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_configs');
    }
};
