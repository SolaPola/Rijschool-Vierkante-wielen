<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, make sure any existing 'hybrid' values are saved
        $hybridCars = DB::table('cars')->where('fuel', 'hybrid')->get();
        
        // Alter the enum values to include all required options
        DB::statement("ALTER TABLE cars MODIFY COLUMN fuel ENUM('petrol', 'diesel', 'electric', 'hybrid') NOT NULL");
        
        // Re-apply hybrid values if they were lost during the alteration
        foreach ($hybridCars as $car) {
            DB::table('cars')
                ->where('id', $car->id)
                ->update(['fuel' => 'hybrid']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is risky as it might truncate data, so we're not implementing a rollback
    }
};
