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
        if (!Schema::hasTable('lessons')) {
            Schema::create('lessons', function (Blueprint $table) {
                $table->id();
                $table->foreignId('instructor_id')->constrained('instructors')->onDelete('cascade');
                $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->dateTime('start_time');
                $table->dateTime('end_time');
                $table->enum('status', ['scheduled', 'confirmed', 'completed', 'cancelled'])->default('scheduled');
                $table->text('notes')->nullable();
                $table->foreignId('vehicle_id')->constrained('cars')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
