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
        Schema::create('mikrotik_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['static', 'pppoe']);
            $table->string('max_download');
            $table->string('max_upload');
            $table->foreignId('mikrotik_id')->constrained()->onDelete('cascade')->nullable();
            $table->integer('price');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mikrotik_packages');
    }
};
