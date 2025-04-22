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
        Schema::create('service_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['static', 'pppoe', 'rhsp']);
            $table->string('max_download')->nullable();
            $table->string('max_upload')->nullable();
            $table->string('rate_limit')->nullable();
            $table->string('profile')->nullable();
            $table->foreignId('mikrotik_id')->constrained()->onDelete('cascade')->nullable();
            $table->integer('price');
            $table->boolean('is_active')->default(1);
            $table->enum('billing_cycle', ['days', 'weeks', 'months', 'years'])->default('months');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_plans');
    }
};
