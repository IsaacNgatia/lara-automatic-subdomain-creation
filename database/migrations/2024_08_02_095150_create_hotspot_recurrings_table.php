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
        Schema::create('hotspot_recurrings', function (Blueprint $table) {
            $table->id();
            $table->string('mikrotik_name');
            $table->string('password')->nullable();
            $table->string('server');
            $table->string('profile');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->boolean('disabled')->default(false);
            $table->string('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotspot_recurrings');
    }
};
