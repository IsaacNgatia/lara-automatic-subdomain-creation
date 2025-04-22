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
        Schema::create('hotspot_epays', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('password')->nullable();
            $table->integer('time_limit');
            $table->integer('data_limit')->nullable();
            $table->foreignId('epay_package_id')->constrained();
            $table->integer('price');
            $table->boolean('is_sold')->default(false);
            $table->boolean('logged_in')->default(false);
            $table->foreignId('mikrotik_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('hotspot_epays');
    }
};
