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
        Schema::create('mikrotiks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('user');
            $table->string('password');
            $table->ipAddress('ip')->default('165.227.170.20');
            $table->integer('port');
            $table->string('location');
            $table->string('recipient')->nullable();
            $table->boolean('nat')->default(0)->nullable();
            $table->boolean('queue_types')->default(0)->nullable();
            $table->boolean('smartolt')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mikrotiks');
    }
};
