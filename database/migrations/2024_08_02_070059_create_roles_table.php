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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });
        // Insert Default Roles
        DB::table('roles')->insert([
            ['name'=> 'Developer','description'=> 'Full access to the system and his activities are not logged'],
            ['name'=> 'Super Admin','description'=> 'Full access to the system'],
            ['name'=> 'Billing Admin','description'=> 'Manages customer accounts and billing'],
            ['name'=> 'Technical Support Admin','description'=> 'Handles technical support and network issues'],
            ['name'=> 'Customer Service Admin','description'=> 'Manages customer service and account details'],
            ['name' => 'Network Admin', 'description' => 'Manages network infrastructure and configurations'],
            ['name'=> 'Reporting Admin','description'=> 'Generates system reports and analytics'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
