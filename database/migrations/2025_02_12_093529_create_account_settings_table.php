<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('account_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('value');
            $table->timestamps();
        });
        DB::table('account_settings')->insert(
            [
                ['key' => 'account_title', 'value' => 'ISP Kenya'],
                ['key' => 'phone', 'value' => ''],
                ['key' => 'email', 'value' => ''],
                ['key' => 'logo_url', 'value' => ''],
                ['key' => 'favicon_url', 'value' => ''],
                ['key' => 'admin_url', 'value' => ''],
                ['key' => 'client_url', 'value' => ''],
                ['key' => 'hotspot_title', 'value' => ''],

            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_settings');
    }
};
