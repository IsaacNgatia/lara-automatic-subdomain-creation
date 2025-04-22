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
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
        });
        // Default role_permissions data
        DB::table('role_permissions')->insert([
            ['role_id'=> '1','permission_id'=> '1'],
            ['role_id'=> '1','permission_id'=> '2'],
            ['role_id'=> '1','permission_id'=> '3'],
            ['role_id'=> '1','permission_id'=> '4'],
            ['role_id'=> '1','permission_id'=> '5'],
            ['role_id'=> '1','permission_id'=> '6'],
            ['role_id'=> '1','permission_id'=> '7'],
            ['role_id'=> '1','permission_id'=> '8'],
            ['role_id'=> '1','permission_id'=> '9'],
            ['role_id'=> '1','permission_id'=> '10'],
            ['role_id'=> '1','permission_id'=> '11'],
            ['role_id'=> '1','permission_id'=> '12'],
            ['role_id'=> '1','permission_id'=> '13'],
            ['role_id'=> '1','permission_id'=> '14'],
            ['role_id'=> '1','permission_id'=> '15'],
            ['role_id'=> '1','permission_id'=> '16'],
            ['role_id'=> '1','permission_id'=> '17'],
            ['role_id'=> '1','permission_id'=> '18'],
            ['role_id'=> '1','permission_id'=> '19'],
            ['role_id'=> '1','permission_id'=> '20'],
            ['role_id'=> '1','permission_id'=> '21'],
            ['role_id'=> '1','permission_id'=> '22'],
            ['role_id'=> '1','permission_id'=> '23'],
            ['role_id'=> '1','permission_id'=> '24'],
            ['role_id'=> '1','permission_id'=> '25'],
            ['role_id'=> '1','permission_id'=> '26'],
            ['role_id'=> '1','permission_id'=> '27'],
            ['role_id'=> '1','permission_id'=> '28'],
            ['role_id'=> '1','permission_id'=> '29'],
            ['role_id'=> '1','permission_id'=> '30'],
            ['role_id'=> '2','permission_id'=> '1'],
            ['role_id'=> '2','permission_id'=> '2'],
            ['role_id'=> '2','permission_id'=> '3'],
            ['role_id'=> '2','permission_id'=> '4'],
            ['role_id'=> '2','permission_id'=> '5'],
            ['role_id'=> '2','permission_id'=> '6'],
            ['role_id'=> '2','permission_id'=> '7'],
            ['role_id'=> '2','permission_id'=> '8'],
            ['role_id'=> '2','permission_id'=> '9'],
            ['role_id'=> '2','permission_id'=> '10'],
            ['role_id'=> '2','permission_id'=> '11'],
            ['role_id'=> '2','permission_id'=> '12'],
            ['role_id'=> '2','permission_id'=> '13'],
            ['role_id'=> '2','permission_id'=> '14'],
            ['role_id'=> '2','permission_id'=> '15'],
            ['role_id'=> '2','permission_id'=> '16'],
            ['role_id'=> '2','permission_id'=> '17'],
            ['role_id'=> '2','permission_id'=> '18'],
            ['role_id'=> '2','permission_id'=> '19'],
            ['role_id'=> '2','permission_id'=> '20'],
            ['role_id'=> '2','permission_id'=> '21'],
            ['role_id'=> '2','permission_id'=> '22'],
            ['role_id'=> '2','permission_id'=> '23'],
            ['role_id'=> '2','permission_id'=> '24'],
            ['role_id'=> '2','permission_id'=> '25'],
            ['role_id'=> '2','permission_id'=> '26'],
            ['role_id'=> '2','permission_id'=> '27'],
            ['role_id'=> '2','permission_id'=> '28'],
            ['role_id'=> '2','permission_id'=> '29'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
