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
        Schema::create('hotspot_cashes', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_name');
            $table->string('password')->nullable();
            $table->string('reference_number')->unique();
            $table->integer('time_limit');
            $table->integer('data_limit');
            $table->string('server');
            $table->string('profile');
            $table->boolean('is_sold')->default(false);
            $table->boolean('logged_in')->default(false);
            $table->foreignId('mikrotik_id')->constrained()->onDelete('cascade');
            $table->integer('price');
            $table->string('comment');
            $table->dateTime('payment_date')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotspot_cashes');
    }
};
