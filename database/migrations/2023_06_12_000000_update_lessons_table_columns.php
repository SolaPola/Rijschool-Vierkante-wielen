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
        // First, check if the vehicle_id column exists and car_id doesn't exist
        if (Schema::hasColumn('lessons', 'vehicle_id') && !Schema::hasColumn('lessons', 'car_id')) {
            // Create a backup of existing data
            $lessons = DB::table('lessons')->get();
            
            // Add car_id column
            Schema::table('lessons', function (Blueprint $table) {
                $table->unsignedBigInteger('car_id')->nullable()->after('instructor_id');
            });
            
            // Copy vehicle_id values to car_id for all existing records
            foreach ($lessons as $lesson) {
                if (isset($lesson->vehicle_id)) {
                    DB::table('lessons')
                        ->where('id', $lesson->id)
                        ->update(['car_id' => $lesson->vehicle_id]);
                }
            }
            
            // Add foreign key constraint to car_id
            Schema::table('lessons', function (Blueprint $table) {
                $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
            });
        }
        
        // Fix column names if the database is using different names than the code expects
        if (!Schema::hasColumn('lessons', 'start_datetime') && Schema::hasColumn('lessons', 'start_time')) {
            Schema::table('lessons', function (Blueprint $table) {
                $table->renameColumn('start_time', 'start_datetime');
            });
        }
        
        if (!Schema::hasColumn('lessons', 'end_datetime') && Schema::hasColumn('lessons', 'end_time')) {
            Schema::table('lessons', function (Blueprint $table) {
                $table->renameColumn('end_time', 'end_datetime');
            });
        }
        
        // Check if status needs to be renamed to lesson_status
        if (!Schema::hasColumn('lessons', 'lesson_status') && Schema::hasColumn('lessons', 'status')) {
            Schema::table('lessons', function (Blueprint $table) {
                $table->renameColumn('status', 'lesson_status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the changes (revert column names)
        if (Schema::hasColumn('lessons', 'start_datetime') && !Schema::hasColumn('lessons', 'start_time')) {
            Schema::table('lessons', function (Blueprint $table) {
                $table->renameColumn('start_datetime', 'start_time');
            });
        }
        
        if (Schema::hasColumn('lessons', 'end_datetime') && !Schema::hasColumn('lessons', 'end_time')) {
            Schema::table('lessons', function (Blueprint $table) {
                $table->renameColumn('end_datetime', 'end_time');
            });
        }
        
        if (Schema::hasColumn('lessons', 'lesson_status') && !Schema::hasColumn('lessons', 'status')) {
            Schema::table('lessons', function (Blueprint $table) {
                $table->renameColumn('lesson_status', 'status');
            });
        }
        
        // Only drop car_id if it exists and vehicle_id also exists
        if (Schema::hasColumn('lessons', 'car_id') && Schema::hasColumn('lessons', 'vehicle_id')) {
            Schema::table('lessons', function (Blueprint $table) {
                $table->dropForeign(['car_id']);
                $table->dropColumn('car_id');
            });
        }
    }
};
