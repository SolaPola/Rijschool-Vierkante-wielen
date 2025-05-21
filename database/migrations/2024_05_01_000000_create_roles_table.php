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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default roles
        DB::table('roles')->insert([
            ['name' => 'student', 'description' => 'Student role with basic access'],
            ['name' => 'instructor', 'description' => 'Instructor role with teaching privileges'],
            ['name' => 'administrator', 'description' => 'Administrator role with full access']
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
