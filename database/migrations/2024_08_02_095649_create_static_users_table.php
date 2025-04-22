<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('static_users', function (Blueprint $table) {
            $table->id();
            $table->string('mikrotik_name');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('queue_type')->nullable();
            $table->string('max_download_speed')->nullable();
            $table->boolean('disabled')->default(0);
            $table->ipAddress('target_address');
            $table->string('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('static_customers');
    }
};
