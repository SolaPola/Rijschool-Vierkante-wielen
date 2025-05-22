<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Lesson extends Model
{
    use HasFactory;


    protected $fillable = [
        'instructor_id',
        'student_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'status',  // 'scheduled', 'confirmed', 'completed', 'cancelled'
        'notes',
        'vehicle_id',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }




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
