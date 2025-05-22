<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'registration_id',
        'instructor_id',
        'car_id',
        'start_datetime',
        'end_datetime',
        'lesson_status',
        'goal',
        'student_comment',
        'commentary_instructor',
        'remark',
        'isactive'
    ];

    /**
     * Get the registration associated with the lesson.
     */
    public function registration()
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }

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
        return $this->belongsTo(Car::class, 'car_id');
    }
}
