<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email');
            $table->string('password');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->string('phone_number')->default('0712345678');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained('admins')->onDelete('cascade')->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
        DB::table('admins')->insert([
            ['username' => 'Ispkenya Developer', 'email' => 'developer@ispkenya.co.ke', 'password' => '$2y$12$e5jUm.4Kkvz8T.PRLuFFnOiRt.kAnhTHF7bu7tOIXsUz/7n1YECRa', 'role_id' => '1', 'phone_number' => '0790008915', 'email_verified_at' => null, 'profile_photo_path' => null, 'remember_token' => null, 'created_at' => now(env('TIME_ZONE')), 'updated_at' => now(env('TIME_ZONE'))],
            ['username' => 'Ispkenya Admin', 'email' => 'admin@ispkenya.co.ke', 'password' => '$2y$12$e5jUm.4Kkvz8T.PRLuFFnOiRt.kAnhTHF7bu7tOIXsUz/7n1YECRa', 'role_id' => '2', 'phone_number' => '0712345678', 'email_verified_at' => null, 'profile_photo_path' => null, 'remember_token' => null, 'created_at' => now(env('TIME_ZONE')), 'updated_at' => now(env('TIME_ZONE'))],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
