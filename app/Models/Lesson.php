<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'instructor_id',
        'student_id',
        'vehicle_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'status',
        'notes'
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
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the instructor that owns the lesson.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }

    /**
     * Get the car used for the lesson.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'vehicle_id');
    }

    /**
     * Check if there's an overlapping car schedule for the given time period
     *
     * @param int $carId
     * @param string $startDateTime
     * @param string $endDateTime
     * @param int|null $excludeLessonId
     * @return bool
     */
    public static function hasOverlappingCarSchedule($carId, $startDateTime, $endDateTime, $excludeLessonId = null)
    {
        $query = self::where('vehicle_id', $carId)
            ->where('status', '!=', 'cancelled')
            ->where(function($q) use ($startDateTime, $endDateTime) {
                $q->whereBetween('start_time', [$startDateTime, $endDateTime])
                  ->orWhereBetween('end_time', [$startDateTime, $endDateTime])
                  ->orWhere(function($innerQ) use ($startDateTime, $endDateTime) {
                      $innerQ->where('start_time', '<=', $startDateTime)
                             ->where('end_time', '>=', $endDateTime);
                  });
            });
        
        // Exclude the current lesson if we're updating
        if ($excludeLessonId) {
            $query->where('id', '!=', $excludeLessonId);
        }
        
        return $query->exists();
    }
}
