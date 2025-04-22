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
            $table->string('username');
            $table->string('password')->nullable();
            $table->bigInteger('time_limit');
            $table->bigInteger('data_limit')->nullable();
            $table->string('server');
            $table->string('profile');
            $table->boolean('is_sold')->default(false);
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
