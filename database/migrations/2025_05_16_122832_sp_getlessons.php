<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS sp_getlessons;
            CREATE PROCEDURE sp_getlessons
            (IN instructorId INT, IN startDate DATE, IN endDate DATE)
            BEGIN
                SELECT * FROM driving_lessons
                WHERE instructor_id = instructorId
                AND start_date >= startDate
                AND end_date <= endDate;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getlessons');
    }
};
