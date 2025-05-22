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
         DB::unprepared("
    DROP PROCEDURE IF EXISTS GetInstructorById;
    CREATE PROCEDURE GetInstructorById(IN instructor_id INT)
    BEGIN
        SELECT 
            i.id,
            i.number AS license_number,
            i.isactive,
            i.remark,
            CONCAT(u.firstname, ' ', IF(u.infix IS NOT NULL AND u.infix != '', CONCAT(u.infix, ' '), ''), u.lastname) AS name,
            u.email,
            u.username,
            u.birthdate,
            u.is_active AS user_status,
            u.created_at,
            u.updated_at,
            CASE 
                WHEN i.isactive = 1 AND u.is_active = 1 THEN 'Active'
                WHEN i.isactive = 0 THEN 'Inactive'
                ELSE 'On Leave'
            END AS status
        FROM instructors i
        INNER JOIN users u ON i.user_id = u.id
        WHERE i.id = instructor_id;
    END;
    ");
    }

    /**
     * Reverse the migrations.
     */

public function down(): void
{
    DB::unprepared("DROP PROCEDURE IF EXISTS GetInstructorById");
}
};
