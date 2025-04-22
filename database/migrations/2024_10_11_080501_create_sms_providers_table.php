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
        Schema::create('sms_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('api_key')->default(false);
            $table->boolean('sender_id')->default(true);
            $table->boolean('username')->default(false);
            $table->boolean('password')->default(false);
            $table->boolean('short_code')->default(false);
            $table->boolean('api_secret')->default(false);
            $table->boolean('_all')->default(false);
            $table->enum('output_type', ['json', 'plain'])->nullable();
            $table->timestamp('created_at');
        });
        DB::table('sms_providers')->insert([
            ['name' => 'textsms', 'api_key' => 1, 'sender_id' => 1, 'username' => 0, 'password' => 0, 'short_code' => 1, 'api_secret' => 0, '_all' => 0, 'output_type' => 'plain', 'created_at' => now(env('TIME_ZONE'))],
            ['name' => 'celcomafrica', 'api_key' => 1, 'sender_id' => 1, 'username' => 0, 'password' => 0, 'short_code' => 1, 'api_secret' => 0, '_all' => 0, 'output_type' => 'plain', 'created_at' => now(env('TIME_ZONE'))],
            ['name' => 'advanta', 'api_key' => 1, 'sender_id' => 1, 'username' => 0, 'password' => 0, 'short_code' => 1, 'api_secret' => 0, '_all' => 0, 'output_type' => 'plain', 'created_at' => now(env('TIME_ZONE'))],
            ['name' => 'afrinet', 'api_key' => 1, 'sender_id' => 1, 'username' => 0, 'password' => 0, 'short_code' => 1, 'api_secret' => 0, '_all' => 0, 'output_type' => 'plain', 'created_at' => now(env('TIME_ZONE'))],
            ['name' => 'talksasa', 'api_key' => 1, 'sender_id' => 1, 'username' => 0, 'password' => 0, 'short_code' => 1, 'api_secret' => 0, '_all' => 0, 'output_type' => 'plain', 'created_at' => now(env('TIME_ZONE'))],
            ['name' => 'mobitech', 'api_key' => 1, 'sender_id' => 1, 'username' => 0, 'password' => 0, 'short_code' => 0, 'api_secret' => 0, '_all' => 0, 'output_type' => 'plain', 'created_at' => now(env('TIME_ZONE'))],
            ['name' => 'africastalking', 'api_key' => 1, 'sender_id' => 1, 'username' => 1, 'password' => 0, 'short_code' => 0, 'api_secret' => 0, '_all' => 0, 'output_type' => null, 'created_at' => now(env('TIME_ZONE'))],
            ['name' => 'hostpinnacle', 'api_key' => 1, 'sender_id' => 1, 'username' => 1, 'password' => 1, 'short_code' => 0, 'api_secret' => 0, '_all' => 0, 'output_type' => null, 'created_at' => now(env('TIME_ZONE'))],
            ['name' => 'bytewave', 'api_key' => 1, 'sender_id' => 1, 'username' => 0, 'password' => 0, 'short_code' => 0, 'api_secret' => 0, '_all' => 0, 'output_type' => 'plain', 'created_at' => now(env('TIME_ZONE'))],
            ['name' => 'afrokatt', 'api_key' => 1, 'sender_id' => 1, 'username' => 0, 'password' => 0, 'short_code' => 0, 'api_secret' => 0, '_all' => 0, 'output_type' => null, 'created_at' => now(env('TIME_ZONE'))],
            ['name' => 'sasatelkom', 'api_key' => 0, 'sender_id' => 1, 'username' => 1, 'password' => 1, 'short_code' => 0, 'api_secret' => 0, '_all' => 0, 'output_type' => null, 'created_at' => now(env('TIME_ZONE'))],
            ['name' => 'mobilesasa', 'api_key' => 1, 'sender_id' => 1, 'username' => 0, 'password' => 0, 'short_code' => 0, 'api_secret' => 0, '_all' => 0, 'output_type' => null, 'created_at' => now(env('TIME_ZONE'))],
            ['name' => 'mspace', 'api_key' => 1, 'sender_id' => 1, 'username' => 1, 'password' => 1, 'short_code' => 0, 'api_secret' => 0, '_all' => 0, 'output_type' => null, 'created_at' => now(env('TIME_ZONE'))],
            ['name' => 'smsleopard', 'api_key' => 1, 'sender_id' => 1, 'username' => 0, 'password' => 0, 'short_code' => 0, 'api_secret' => 1, '_all' => 0, 'output_type' => null, 'created_at' => now(env('TIME_ZONE'))],
            ['name' => 'zettatel', 'api_key' => 1, 'sender_id' => 1, 'username' => 0, 'password' => 0, 'short_code' => 0, 'api_secret' => 0, '_all' => 0, 'output_type' => null, 'created_at' => now(env('TIME_ZONE'))],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_providers');
    }
};
