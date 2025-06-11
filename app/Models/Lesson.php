<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Lesson extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lessons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'instructor_id',
        'vehicle_id',
        'start_time',
        'end_time',
        'status',
        'title',
        'description',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get the student that owns the lesson.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the instructor that owns the lesson.
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }

    /**
     * Get the car that is used for the lesson.
     * This relationship uses vehicle_id to link to cars table
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'vehicle_id');
    }

    /**
     * Check if there are any overlapping lessons with the same car
     *
     * @param int $carId
     * @param string $startTime
     * @param string $endTime
     * @param int|null $excludeLessonId Exclude a specific lesson from the check (useful for updates)
     * @return bool
     */
    public static function hasOverlappingCarSchedule($carId, $startTime, $endTime, $excludeLessonId = null)
    {
        $query = self::where('vehicle_id', $carId)
            ->where(function($query) use ($startTime, $endTime) {
                // Find lessons where:
                // 1. The lesson starts during our new lesson time
                // 2. The lesson ends during our new lesson time
                // 3. The lesson starts before and ends after our new lesson time
                $query->where(function($q) use ($startTime, $endTime) {
                    $q->whereBetween('start_time', [$startTime, $endTime]);
                })->orWhere(function($q) use ($startTime, $endTime) {
                    $q->whereBetween('end_time', [$startTime, $endTime]);
                })->orWhere(function($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<=', $startTime)
                      ->where('end_time', '>=', $endTime);
                });
            })
            ->where('status', '!=', 'cancelled'); // Ignore cancelled lessons
            
        // Exclude the current lesson if we're updating
        if ($excludeLessonId) {
            $query->where('id', '!=', $excludeLessonId);
        }
        
        return $query->exists();
    }
}
