<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstname',
        'infix',
        'lastname',
        'username',
        'birthdate',
        'email',
        'password',
        'is_active',
        'is_logged_in',
        'logged_in',
        'logged_out',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the role associated with the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role->name === $roleName;
    }

    /**
     * Determine if user is an administrator
     * 
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role && $this->role->name === 'administrator';
    }

    /**
     * Determine if user is an instructor
     * 
     * @return bool
     */
    public function isInstructor()
    {
        return $this->role && $this->role->name === 'instructor';
    }

    /**
     * Determine if user is a student
     * 
     * @return bool
     */
    public function isStudent()
    {
        return $this->role && $this->role->name === 'student';
    }

    /**
     * Get the instructor profile associated with the user.
     */
    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }

    /**
     * Get the student profile associated with the user.
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }
}
