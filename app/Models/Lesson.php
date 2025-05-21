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



}
