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
        Schema::create('pppoe_users', function (Blueprint $table) {
            $table->id();
            $table->string('mikrotik_name');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('profile');
            $table->string('password')->nullable();
            $table->string('service')->default('pppoe');
            $table->ipAddress('remote_address')->nullable();
            $table->boolean('disabled')->default(0);
            $table->string('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pppoe_customers');
    }
};
