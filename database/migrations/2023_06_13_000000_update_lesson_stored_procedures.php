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
        // Update the GetDrivingLessonById procedure to use the correct column names
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
                       IFNULL(l.isactive, 1) as isactive,
                       l.created_at, 
                       l.updated_at
                FROM lessons l
                JOIN students s ON l.student_id = s.id
                JOIN users su ON s.user_id = su.id
                JOIN instructors i ON l.instructor_id = i.id
                JOIN users iu ON i.user_id = iu.id
                JOIN cars c ON l.vehicle_id = c.id
                WHERE l.id = lesson_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore the original procedure (if needed)
        DB::unprepared('
            DROP PROCEDURE IF EXISTS GetDrivingLessonById;
            CREATE PROCEDURE GetDrivingLessonById(IN lesson_id INT)
            BEGIN
                SELECT l.id, 
                       l.start_datetime, 
                       l.end_datetime, 
                       l.lesson_status, 
                       r.id as registration_id,
                       s.id as student_id,
                       CONCAT(su.firstname, " ", su.lastname) as student_name,
                       i.id as instructor_id,
                       CONCAT(iu.firstname, " ", iu.lastname) as instructor_name,
                       c.id as car_id,
                       c.brand,
                       c.model,
                       l.goal, 
                       l.student_comment, 
                       l.commentary_instructor, 
                       l.remark, 
                       l.isactive,
                       l.created_at, 
                       l.updated_at
                FROM lessons l
                JOIN registrations r ON l.registration_id = r.id
                JOIN students s ON r.student_id = s.id
                JOIN users su ON s.user_id = su.id
                JOIN instructors i ON l.instructor_id = i.id
                JOIN users iu ON i.user_id = iu.id
                JOIN cars c ON l.car_id = c.id
                WHERE l.id = lesson_id AND l.isactive = TRUE;
            END
        ');
    }
};
