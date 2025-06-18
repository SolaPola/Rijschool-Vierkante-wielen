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
        // Drop and recreate the GetDrivingLessonById procedure with the correct column mapping
        DB::unprepared('
            DROP PROCEDURE IF EXISTS GetDrivingLessonById;
            CREATE PROCEDURE GetDrivingLessonById(IN lesson_id INT)
            BEGIN
                SELECT l.id, 
                       l.start_time as start_datetime, 
                       l.end_time as end_datetime, 
                       l.status as lesson_status, 
                       l.student_id,
                       CONCAT(su.firstname, " ", su.lastname) as student_name,
                       l.instructor_id,
                       CONCAT(iu.firstname, " ", iu.lastname) as instructor_name,
                       l.vehicle_id as car_id,
                       c.brand,
                       c.type as model,
                       l.title as goal, 
                       l.description as student_comment, 
                       l.notes as commentary_instructor, 
                       l.description as remark, 
                       1 as isactive,
                       l.created_at, 
                       l.updated_at
                FROM lessons l
                JOIN students s ON l.student_id = s.id
                JOIN users su ON s.user_id = su.id
                JOIN instructors i ON l.instructor_id = i.id
                JOIN users iu ON i.user_id = iu.id
                LEFT JOIN cars c ON l.vehicle_id = c.id
                WHERE l.id = lesson_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to the previous stored procedure definition if needed
        DB::unprepared('
            DROP PROCEDURE IF EXISTS GetDrivingLessonById;
        ');
    }
};
