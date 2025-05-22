<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLessonStoredProcedures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // GetAllDrivingLessons procedure
        DB::unprepared('
            DROP PROCEDURE IF EXISTS GetAllDrivingLessons;
            CREATE PROCEDURE GetAllDrivingLessons()
            BEGIN
                SELECT l.id, 
                       l.start_date, 
                       l.end_date, 
                       l.lesson_status, 
                       r.id as registration_id,
                       s.id as student_id,
                       CONCAT(su.firstname, " ", su.lastname) as student_name,
                       i.id as instructor_id,
                       CONCAT(iu.firstname, " ", iu.lastname) as instructor_name,
                       c.id as car_id,
                       c.brand,
                       c.type,
                       l.goal, 
                       l.student_comment, 
                       l.commentary_instructor, 
                       l.remark, 
                       l.isactive,
                       l.created_at, 
                       l.updated_at
                FROM driving_lessons l
                JOIN registrations r ON l.registration_id = r.id
                JOIN students s ON r.student_id = s.id
                JOIN users su ON s.user_id = su.id
                JOIN instructors i ON l.instructor_id = i.id
                JOIN users iu ON i.user_id = iu.id
                JOIN cars c ON l.car_id = c.id
                WHERE l.isactive = TRUE
                ORDER BY l.start_date;
            END
        ');

        // GetDrivingLessonById procedure
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

        // InsertDrivingLesson procedure
        DB::unprepared('
            DROP PROCEDURE IF EXISTS InsertDrivingLesson;
            CREATE PROCEDURE InsertDrivingLesson(
                IN p_registration_id INT,
                IN p_instructor_id INT,
                IN p_car_id INT,
                IN p_start_datetime DATETIME,
                IN p_end_datetime DATETIME,
                IN p_lesson_status VARCHAR(50),
                IN p_goal TEXT,
                IN p_student_comment TEXT,
                IN p_commentary_instructor TEXT,
                IN p_remark TEXT
            )
            BEGIN
                INSERT INTO lessons (
                    registration_id,
                    instructor_id,
                    car_id,
                    start_datetime,
                    end_datetime,
                    lesson_status,
                    goal,
                    student_comment,
                    commentary_instructor,
                    remark,
                    isactive,
                    created_at,
                    updated_at
                ) VALUES (
                    p_registration_id,
                    p_instructor_id,
                    p_car_id,
                    p_start_datetime,
                    p_end_datetime,
                    p_lesson_status,
                    p_goal,
                    p_student_comment,
                    p_commentary_instructor,
                    p_remark,
                    TRUE,
                    NOW(),
                    NOW()
                );
            END
        ');

        // UpdateDrivingLesson procedure
        DB::unprepared('
            DROP PROCEDURE IF EXISTS UpdateDrivingLesson;
            CREATE PROCEDURE UpdateDrivingLesson(
                IN p_id INT,
                IN p_registration_id INT,
                IN p_instructor_id INT,
                IN p_car_id INT,
                IN p_start_datetime DATETIME,
                IN p_end_datetime DATETIME,
                IN p_lesson_status VARCHAR(50),
                IN p_goal TEXT,
                IN p_student_comment TEXT,
                IN p_commentary_instructor TEXT,
                IN p_isactive BOOLEAN,
                IN p_remark TEXT
            )
            BEGIN
                UPDATE lessons
                SET registration_id = p_registration_id,
                    instructor_id = p_instructor_id,
                    car_id = p_car_id,
                    start_datetime = p_start_datetime,
                    end_datetime = p_end_datetime,
                    lesson_status = p_lesson_status,
                    goal = p_goal,
                    student_comment = p_student_comment,
                    commentary_instructor = p_commentary_instructor,
                    isactive = p_isactive,
                    remark = p_remark,
                    updated_at = NOW()
                WHERE id = p_id;
            END
        ');

        // DeleteDrivingLesson procedure
        DB::unprepared('
            DROP PROCEDURE IF EXISTS DeleteDrivingLesson;
            CREATE PROCEDURE DeleteDrivingLesson(IN lesson_id INT)
            BEGIN
                UPDATE lessons
                SET isactive = FALSE,
                    updated_at = NOW()
                WHERE id = lesson_id;
            END
        ');

        // GetDrivingLessonsByStudent procedure
        DB::unprepared('
            DROP PROCEDURE IF EXISTS GetDrivingLessonsByStudent;
            CREATE PROCEDURE GetDrivingLessonsByStudent(IN student_id INT)
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
                WHERE s.id = student_id AND l.isactive = TRUE
                ORDER BY l.start_datetime;
            END
        ');

        // GetDrivingLessonsByInstructor procedure
        DB::unprepared('
            DROP PROCEDURE IF EXISTS GetDrivingLessonsByInstructor;
            CREATE PROCEDURE GetDrivingLessonsByInstructor(
                IN instructor_id INT,
                IN start_date DATE,
                IN end_date DATE
            )
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
                WHERE i.id = instructor_id 
                AND DATE(l.start_datetime) BETWEEN start_date AND end_date
                AND l.isactive = TRUE
                ORDER BY l.start_datetime;
            END
        ');

        // GetDrivingLessonsByCar procedure
        DB::unprepared('
            DROP PROCEDURE IF EXISTS GetDrivingLessonsByCar;
            CREATE PROCEDURE GetDrivingLessonsByCar(
                IN car_id INT,
                IN start_date DATE,
                IN end_date DATE
            )
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
                WHERE c.id = car_id 
                AND DATE(l.start_datetime) BETWEEN start_date AND end_date
                AND l.isactive = TRUE
                ORDER BY l.start_datetime;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop all procedures
        DB::unprepared('DROP PROCEDURE IF EXISTS GetAllDrivingLessons');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetDrivingLessonById');
        DB::unprepared('DROP PROCEDURE IF EXISTS InsertDrivingLesson');
        DB::unprepared('DROP PROCEDURE IF EXISTS UpdateDrivingLesson');
        DB::unprepared('DROP PROCEDURE IF EXISTS DeleteDrivingLesson');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetDrivingLessonsByStudent');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetDrivingLessonsByInstructor');
        DB::unprepared('DROP PROCEDURE IF EXISTS GetDrivingLessonsByCar');
    }
}
