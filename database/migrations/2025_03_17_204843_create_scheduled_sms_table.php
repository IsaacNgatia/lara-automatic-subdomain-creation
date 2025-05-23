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
        Schema::create('scheduled_sms', function (Blueprint $table) {
            $table->id();
            $table->integer('day_to_send');
            $table->enum('before_after', ['before', 'after'])->default('before')->nullable();
            $table->text('template');
            $table->string('type', 30)->default('expiry-sms')->nullable();
            $table->foreignId('created_by')->constrained('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_sms');
    }
};
