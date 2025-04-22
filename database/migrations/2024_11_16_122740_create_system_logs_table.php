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
        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('level', ['INFO', 'WARNING', 'ERROR', 'CRITICAL'])->default('INFO');
            $table->string('event_type');
            $table->string('message');
            $table->enum('status', ['success', 'failed', 'pending'])->default('success');
            $table->text('description');
            $table->string('file_path')->nullable();
            $table->string('source')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_logs');
    }
};
