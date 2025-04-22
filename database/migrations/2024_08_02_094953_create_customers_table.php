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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('official_name');
            $table->string('email')->nullable();
            $table->string('reference_number')->unique();
            $table->string('phone_number');
            $table->unsignedBigInteger('parent_account')->nullable();
            $table->boolean('is_parent')->nullable()->default(false);
            $table->enum('connection_type', ['static', 'pppoe', 'rhsp']);
            $table->string('location')->nullable();
            $table->foreignId('mikrotik_id')->constrained()->onDelete('cascade'); // Foreign key referencing 'mikrotik' table
            $table->integer('billing_amount');
            $table->decimal('balance', 8, 2)->default('0.00');
            $table->string('billing_cycle')->default('1 month');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->float('installation_fee')->nullable();
            $table->dateTime('grace_date')->nullable();
            $table->date('last_payment_date')->nullable();
            $table->dateTime('expiry_date');
            $table->string('password');
            $table->text('note')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
        Schema::dropIfExists('client_sessions');
    }
};
