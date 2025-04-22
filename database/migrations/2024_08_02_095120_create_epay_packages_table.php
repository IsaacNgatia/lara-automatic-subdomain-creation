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
        Schema::create('epay_packages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('password_status')->default(1);
            $table->string('server');
            $table->string('profile');
            $table->integer('price');
            $table->integer('voucher_length')->default('6');
            $table->foreignId('mikrotik_id')->constrained()->onDelete('cascade');
            $table->bigInteger('time_limit');
            $table->bigInteger('data_limit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epay_packages');
    }
};
