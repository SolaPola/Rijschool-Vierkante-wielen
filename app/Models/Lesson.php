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
        'instructor_id',
        'student_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'status',
        'notes',
        'vehicle_id', // This is the correct column name instead of car_id
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
     * Get the instructor associated with the lesson.
     */
    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    /**
     * Get the car associated with the lesson.
     */
    public function car()
    {
        return $this->belongsTo(Car::class, 'vehicle_id'); // Using vehicle_id as foreign key
    }
    
    /**
     * Get the student associated with the lesson.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
