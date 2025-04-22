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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('reference_number')->unique();
            $table->string('invoice_date')->nullable();
            $table->string('due_date')->nullable();
            $table->string('title')->nullable();
            $table->decimal('total', 16, 2)->default(0);
            $table->unsignedBigInteger('generated_by')->nullable();
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->longText('notes')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
