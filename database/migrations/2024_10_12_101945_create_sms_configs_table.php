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
        Schema::create('sms_configs', function (Blueprint $table) {
            $table->id();
            $table->string('sms_provider_id')->constrained()->onDelete('cascade');
            $table->string('api_key')->nullable();
            $table->string('sender_id')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('short_code')->nullable();
            $table->string('api_secret')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_working')->nullable();
            $table->enum('output_type', ['plain', 'json'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_configs');
    }
};
