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
        Schema::create('client_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('customers')->onDelete('cascade');
            $table->string('action');
            $table->ipAddress('ip_address');
            $table->enum('status', ['success', 'failed', 'pending'])->default('success');
            $table->text('description')->nullable();
            $table->string('user_agent')->comment('This is the browser used to perform an action');
            $table->string('platform')->comment('This is the OS');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_logs');
    }
};
