<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand',
        'type',
        'license_plate',
        'fuel',
        'isactive',
        'remark',
        'maintenance_reason',
        'maintenance_until',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'isactive' => 'boolean',
        'maintenance_until' => 'date',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'maintenance_status',
    ];

    /**
     * Get the lessons associated with this car.
     * Support both 'vehicle_id' and 'car_id' foreign key columns
     */
    public function lessons(): HasMany
    {
        // Try using vehicle_id first (standard naming convention)
        try {
            return $this->hasMany(Lesson::class, 'vehicle_id');
        } catch (\Exception $e) {
            // Fall back to car_id if needed
            return $this->hasMany(Lesson::class, 'car_id');
        }
    }

    /**
     * Get the maintenance status attribute.
     * 
     * @return string
     */
    public function getMaintenanceStatusAttribute()
    {
        if ($this->isactive) {
            return 'available';
        } elseif ($this->maintenance_until && $this->maintenance_until->isFuture()) {
            return 'maintenance';
        } else {
            return 'unavailable';
        }
    }

    /**
     * Check if the car is in maintenance
     * 
     * @return bool
     */
    public function isInMaintenance()
    {
        return !$this->isactive && $this->maintenance_until && $this->maintenance_until->isFuture();
    }
}
